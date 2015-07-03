<?php
/**
 * HtmlPurifierHelper
 *
 * @author Florian Krämer
 * @copyright 2012 - 2015 Florian Krämer
 * @license MIT
 */
namespace Burzum\HtmlPurifier\View\Helper;

use Burzum\HtmlPurifier\Lib\Purifier;
use Cake\View\Helper;

class HtmlPurifierHelper extends Helper {

/**
 * Default config
 *
 * @var array
 */
	public $_defaultConfig = [
		'config' => ''
	];

/**
 * Clean markup
 *
 * @param string $markup
 * @param string $config
 * @return string
 */
	public function clean($markup, $config = null) {
		if (empty($config) && !empty($this->_config['config'])) {
			$config = $this->settings['config'];
		}
		return Purifier::clean($markup, $config);
	}
}
