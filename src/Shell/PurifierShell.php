<?php
/**
 * Purifier Shell
 *
 * @author Florian Krämer
 * @copyright 2012 - 2015 Florian Krämer
 * @license MIT
 */
namespace Burzum\HtmlPurifier\Shell;

use Cake\Console\Shell;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class PurifierShell extends Shell {

	public function main() {}

	/**
	 * Purifies data base content.
	 */
	public function purify() {
		$table = TableRegistry::get($this->param('table'));

		$fields = explode(',', $this->param('fields'));
		foreach ($fields as $field) {
			if (!$table->hasField($field)) {
				$this->abort(sprintf('Table `%s` is missing the field `%s`.', $table->table(), $field));
			}
		}

		if (!in_array('HtmlPurifier', $table->behaviors()->loaded())) {
			$table->addBehavior('Burzum/HtmlPurifier.HtmlPurifier', [
				'fields' => explode(',', $this->param('fields')),
				'purifierConfig' => $this->param('config')
			]);
		}

		$query = $table->find();
		if ($table->hasFinder('purifier')) {
			$query->find('purifier');
		}
		$total = $query->all()->count();

		$this->out(sprintf('Sanitizing fields `%s` in table `%s`', implode(',', $fields), $table->table()));

		$this->helper('progress')->output([
			'total' => $total,
			'callback' => function($progress) use ($total, $table) {
				$chunkSize = 25;
				$chunkCount = 0;
				while ($chunkCount <= $total) {
					$this->_process($table, $chunkCount, $chunkSize);
					$chunkCount = $chunkCount + $chunkSize;
					$progress->increment($chunkSize);
					$progress->draw();
				}
				return;
			}
		]);
	}

	/**
	 * Processes the records.
	 *
	 * @param \Cake\ORM\Table $table
	 * @param int $chunkCount
	 * @param int $chunkSize
	 * @return void
	 */
	protected function _process(Table $table, $chunkCount, $chunkSize) {
		$query = $table->find();
		if ($table->hasFinder('purifier')) {
			$query->find('purifier');
		}

		$fields = explode(',', $this->param('fields'));
		$fields[] = $table->primaryKey();

		$results = $query
			->select($fields)
			->offset($chunkCount)
			->limit($chunkSize)
			->orderDesc($table->aliasField($table->primaryKey()))
			->all();

		if (empty($results)) {
			return;
		}

		foreach ($results as $result) {
			try {
				$table->save($result);
				$chunkCount++;
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
		}
	}

	/**
	 * @inheritDoc
	 */
	public function getOptionParser() {
		$parser = parent::getOptionParser();

		$parser->addArgument('purify', [
			'help' => 'Purifies fields in a table.'
		]);

		$parser->addOption('fields', [
			'short' => 'f',
			'help' => __('The field(s) to purify, comma separated.'),
			'required' => true
		])->addOption('table', [
			'short' => 't',
			'help' => __('The table you want to use.'),
			'required' => true
		])->addOption('config', [
			'short' => 'c',
			'help' => __('The purifier config you want to use.'),
			'default' => 'default'
		]);
		return $parser;
	}
}
