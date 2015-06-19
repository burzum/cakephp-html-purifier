<?php
namespace Burzum\HtmlPurifier\ModelBehavior;

use Cake\ORM\Behavior;
use Burzum\HtmlPurifier\Lib\PurifierTrait;

/**
 * HtmlPurifierBehavior
 *
 * @author Florian Krämer
 * @copyright 2012 Florian Krämer
 * @license MIT
 */
class HtmlPurifierBehavior extends Behavior {

	use PurifierTrait;

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
	public function beforeSave(Event $event) {
		foreach($fields as $field) {
			if (isset($Model->data[$Model->alias][$field])) { 
				$Model->data[$Model->alias][$field] = $this->purifyHtml($Model, $Model->data[$Model->alias][$field], $config);
			}
		}
	}
}
