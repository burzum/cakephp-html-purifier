<?php
/**
 * Purifier
 *
 * @author Florian Krämer
 * @copyright 2012 - 2016 Florian Krämer
 * @license MIT
 */
namespace Burzum\HtmlPurifier\Lib;

trait PurifierTrait {

    /**
     * Cleans markup
     *
     * @param string $markup
     * @param string $config
     */
    public function purifyHtml($markup, $config = '')
    {
        return Purifier::clean($markup, $config);
    }

    /**
     * Gets a HtmlPurifier instance based on a configuration name.
     *
     * @param string $config
     * @return \HtmlPurifier
     */
    public function getHtmlPurifier($config = 'default')
    {
        return Purifier::config($config);
    }
}
