<?php
/**
 * HtmlPurifierHelper
 *
 * @author Florian Krämer
 * @copyright 2012 - 2018 Florian Krämer
 * @license MIT
 */
namespace Burzum\HtmlPurifier\View\Helper;

use Burzum\HtmlPurifier\Lib\Purifier;
use Cake\View\Helper;

/**
 * HtmlPurifierHelper
 */
class HtmlPurifierHelper extends Helper
{

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
     * @param string $markup Markup string to be sanitized
     * @param string $config Purifier config name
     * @return string
     */
    public function clean($markup, $config = null)
    {
        if (empty($config) && !empty($this->_config['config'])) {
            $config = $this->getConfig('config');
        }

        return Purifier::clean($markup, $config);
    }
}
