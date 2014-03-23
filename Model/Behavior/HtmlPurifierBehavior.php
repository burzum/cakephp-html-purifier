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

	public function setup(Model $Model, $settings = array()) {
		$this->settings[$Model->alias] = (array)$settings;
	}
/**
 * beforeSave
 *
 * @param Model $model
 * @return boolean
 */
	public function beforeSave(Model $Model, $options = array()) {
		extract($this->settings[$Model->alias]);
		if (!empty($this->settings[$Model->alias]['fields'])) {
			foreach($this->settings[$Model->alias]['fields'] as $field) {
				if (isset($Model->data[$Model->alias][$field])) {
					$Model->data[$Model->alias][$field] = $this->purifyHtml($Model, $Model->data[$Model->alias][$field], $config);
				}
			}
		}

		if (!empty($this->settings[$Model->alias]['striptags'])) {
			foreach ($this->settings[$Model->alias]['striptags'] as $field) {
				if (isset($Model->data[$Model->alias][$field])) {
					$Model->data[$Model->alias][$field] = $this->stripTags($Model, $Model->data[$Model->alias][$field]);
				}
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

/**
 * strips markup of tags
 * @param Model $Model
 * @param string $markup
 * @return string
 */
	public function stripTags(Model $Model, $markup) {
		return strip_tags($markup);
	}
}