<?php
/**
 * HtmlPurifierHelper
 *
 * @author Florian Krämer
 * @copyright 2012 - 2016 Florian Krämer
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
        'config' => 'default'
    ];

/**
 * Clean markup
 *
 * @param string $markup
 * @param string $config
 * @return string
 */
    public function clean($markup, $config = null)
    {
        if (empty($config) && !empty($this->_config['config'])) {
            $config = $this->config('config');
        }
        return Purifier::clean($markup, $config);
    }
}
