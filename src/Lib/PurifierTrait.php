<?php
/**
 * Purifier
 *
 * @author    Florian Krämer
 * @copyright 2012 - 2018 Florian Krämer
 * @license   MIT
 */
namespace Burzum\HtmlPurifier\Lib;

/**
 * Purifier Trait
 */
trait PurifierTrait
{

    /**
     * Cleans markup
     *
     * @param string $markup
     * @param string $config
     */
    public function purifyHtml($markup, $config = 'default')
    {
        return Purifier::clean($markup, $config);
    }

    /**
     * Gets a HtmlPurifier instance based on a configuration name.
     *
     * @param  string $config
     * @return HTMLPurifier
     */
    public function getHtmlPurifier($config = 'default')
    {
        return Purifier::getPurifierInstance($config);
    }
}
