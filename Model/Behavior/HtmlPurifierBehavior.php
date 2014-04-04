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
 * Setup
 *
 * @param Model $Model
 * @param array $settings
 */
	public function setup(Model $Model, $settings = array()) {
		$this->settings[$Model->alias] = (array)$settings;
	}
/**
 * beforeSave
 *
 * @param Model $Model
 * @param array $options
 * @return boolean
 */
	public function beforeSave(Model $Model, $options = array()) {
		extract($this->settings[$Model->alias]); 

		foreach($fields as $field) { 
			if (isset($Model->data[$Model->alias][$field])) { 
				$Model->data[$Model->alias][$field] = $this->purifyHtml($Model, $Model->data[$Model->alias][$field], $config);
			}
		}

		return true;
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