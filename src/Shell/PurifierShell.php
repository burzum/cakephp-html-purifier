<?php
/**
 * Purifier Shell
 *
 * @author Florian Krämer
 * @copyright 2012 - 2016 Florian Krämer
 * @license MIT
 */
namespace Burzum\HtmlPurifier\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class PurifierShell extends Shell {

    /**
     * Main entry point
     *
     * @return void
     */
    public function main()
    {
        $this->purify();
    }

    /**
     * Gets the table from the shell args.
     *
     * @return \Cake\ORM\Table;
     */
    protected function _getTable()
    {
        $table = TableRegistry::get($this->args[0]);
        $connection = $table->connection();
        $tables = $connection->schemaCollection()->listTables();
        if (!in_array($table->table(), $tables)) {
            $this->abort(__d('Burzum/HtmlPurifier', 'Table `{0}` does not exist in connection `{1}`!', $table->table(), $connection->configName()));
        }
        return $table;
    }

    /**
     * Gets the field(s) from the args and checks if they're present in the table.
     *
     * @param \Cake\ORM\Table $table Table object.
     * @return array Set of of fields explode()'ed from the args
     */
    protected function _getFields(Table $table)
    {
        $fields = explode(',', $this->args[1]);
        foreach ($fields as $field) {
            if (!$table->hasField($field)) {
                $this->abort(sprintf('Table `%s` is missing the field `%s`.', $table->table(), $field));
            }
        }

        return $fields;
    }

    /**
     * Loads the purifier behavior for the given table if not already attached.
     *
     * @param \Cake\ORM\Table $table Table object.
     * @param array Set of fields to sanitize
     * @return void
     */
    protected function _loadBehavior(Table $table, $fields)
    {
        if (!in_array('HtmlPurifier', $table->behaviors()->loaded())) {
            $table->addBehavior('Burzum/HtmlPurifier.HtmlPurifier', [
                'fields' => $fields,
                'purifierConfig' => $this->param('config')
            ]);
        }
    }

    /**
     * Purifies data base content.
     *
     * @return void
     */
    public function purify()
    {
        $table = $this->_getTable();
        $fields = $this->_getFields($table);
        $this->_loadBehavior($table, $fields);

        $query = $table->find();
        if ($table->hasFinder('purifier')) {
            $query->find('purifier');
        }
        $total = $query->all()->count();

        $this->info(__d('Burzum/HtmlPurifier', 'Sanitizing fields `{0}` in table `{1}`', implode(',', $fields), $table->table()));

        $this->helper('progress')->output([
            'total' => $total,
            'callback' => function ($progress) use ($total, $table, $fields) {
                $chunkSize = 25;
                $chunkCount = 0;
                while ($chunkCount <= $total) {
                    $this->_process($table, $chunkCount, $chunkSize, $fields);
                    $chunkCount = $chunkCount + $chunkSize;
                    $progress->increment($chunkSize);
                    $progress->draw();
                }
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
    protected function _process(Table $table, $chunkCount, $chunkSize, $fields) {
        $query = $table->find();
        if ($table->hasFinder('purifier')) {
            $query->find('purifier');
        }

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
                $this->abort($e->getMessage());
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->description([
            __d('Burzum/HtmlPurifier', 'This shell allows you to clean database content with the HTML Purifier.'),
        ]);

        $parser->addArguments([
            'table' => [
                'help' => __d('Burzum/HtmlPurifier', 'The table to sanitize'),
                'required' => true,
            ],
            'fields' => [
                'help' => __d('Burzum/HtmlPurifier', 'The field(s) to purify, comma separated'),
                'required' => true,
            ],
        ]);

        $parser->addOption('config', [
            'short' => 'c',
            'help' => __d('Burzum/HtmlPurifier', 'The purifier config you want to use'),
            'default' => 'default'
        ]);

        return $parser;
    }
}
