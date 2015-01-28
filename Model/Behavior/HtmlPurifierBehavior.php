<?php
App::uses('Purifier', 'HtmlPurifier.Lib');
/**
 * HtmlPurifierBehavior
 *
 * @author Florian Krämer
 * @copyright 2012 Florian Krämer
 * @license MIT
 */
class HtmlPurifierBehavior extends ModelBehavior {

/**
 * Default config
 *
 * @var array
 */
	protected $_defaultConfig = array(
		'purifyOn' => 'beforeSave',
		'fields' => array(),
		'purifierConfig' => 'default',
	);

/**
 * Setup
 *
 * @param Model $Model
 * @param array $settings
 * @throws RuntimeException
 * @return void
 */
	public function setup(Model $Model, $settings = array()) {
		$settings = Hash::merge($this->_defaultConfig, $settings);
		// Legacy check
		if (isset($settings['config'])) {
			$settings['purifierConfig'] = $settings['config'];
		}
		if (!is_string($settings['purifierConfig'])) {
			throw new RuntimeException(__d('html_purifier', 'No purifier config name provided!'));
		}
		$this->settings[$Model->alias] = $settings;
	}

/**
 * beforeSave
 *
 * @param Model $Model
 * @param array $options
 * @return boolean
 */
	public function beforeSave(Model $Model, $options = array()) {
		if ($this->settings[$Model->alias]['purifyOn'] === 'beforeSave') {
			$Model->data = $this->cleanFields($Model, $Model->data);
		}
		return true;
	}

/**
 * afterFind
 *
 * @param Model $Model
 * @param mixed $results The results of the find operation
 * @param bool $primary Whether this model is being queried directly (vs. being queried as an association)
 * @return mixed Purified result of the find operation
 * @return boolean
 */
	public function afterFind(Model $Model, $results, $primary = false) {
		if ($this->settings[$Model->alias]['purifyOn'] === 'afterFind') {
			foreach ($results as $key => $result) {
				$results[$key] = $this->cleanFields($Model, $result);
			}
		}
		return $results;
	}

/**
 * beforeValidate
 *
 * @param Model $Model
 * @param array $options
 * @return boolean
 */
	public function beforeValidate(Model $Model, $options = array()) {
		if ($this->settings[$Model->alias]['purifyOn'] === 'afterSave') {
			$Model->data = $this->cleanFields($Model, $Model->data);
		}
		return true;
	}

/**
 * Cleans fields of a record
 *
 * Provided data must match the structure Model.field, Model.field2...
 *
 * @param Model $Model
 * @param array $data
 * @param array $options
 * @return array
 */
	public function cleanFields(Model $Model, $data = array(), $options = array()) {
		extract(Hash::merge($this->settings[$Model->alias], $options));
		foreach($fields as $field) {
			if (isset($data[$Model->alias][$field])) {
				$data[$Model->alias][$field] = $this->purifyHtml($Model, $data[$Model->alias][$field], $purifierConfig);
			}
		}
		return $data;
	}

/**
 * Cleans markup
 *
 * @param Model $Model
 * @param string $markup
 * @param string $config
 */
	public function purifyHtml(Model $Model, $markup, $config) {
		return Purifier::clean($markup, $config);
	}

}
