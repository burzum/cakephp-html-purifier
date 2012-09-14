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
 * beforeSave
 *
 * @param Model $model
 * @return boolean
 */
	public function beforeSave(Model $Model) {
		extract($this->settings);

		foreach($fields as $field) {
			if (isset($this->data[$this->alias][$field])) {
				$Model->data[$Model->alias][$field] = $this->purifyHtml($Model, $Model->data[$Model->alias][$field]);
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