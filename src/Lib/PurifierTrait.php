<?php
namespace Burzum\HtmlPurifier\Lib;

trait PurifierTrait {

/**
 * Cleans markup
 *
 * @param string $markup
 * @param string $config
 */
	public function purifyHtml($markup, $config) {
		return Purifier::clean($markup, $config);
	}
}