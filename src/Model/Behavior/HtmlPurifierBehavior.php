<?php
/**
 * Purifier
 *
 * @author Florian Krämer
 * @copyright 2012 - 2015 Florian Krämer
 * @license MIT
 */
namespace Burzum\HtmlPurifier\Model\Behavior;

use ArrayObject;
use Burzum\HtmlPurifier\Lib\PurifierTrait;
use Cake\Event\Event;
use Cake\ORM\Behavior;

class HtmlPurifierBehavior extends Behavior {

    use PurifierTrait;

    /**
     * Default config
     *
     * @var array
     */
    protected $_defaultConfig = [
        'fields' => [],
        'purifierConfig' => 'default',
        'implementedEvents' => [
            'Model.beforeMarshal' => 'beforeMarshal',
        ],
        'implementedMethods' => [
            'purifyHtml' => 'purifyHtml'
        ]
    ];

    protected $_purifier;

    /**
     * Before marshal callaback
     *
     * @param \Cake\Event\Event $event The Model.beforeMarshal event.
     * @param \ArrayObject $data Data.
     * @param \ArrayObject $options Options.
     * @return void
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        foreach ($this->config('fields') as $key => $field) {
            if (is_int($key) && isset($data[$field])) {
                $data[$field] = $this->purifyHtml($data[$field], $this->config('purifierConfig'));
            }
            if (is_string($key) && is_string($field)) {
                $data[$key] = $this->purifyHtml($data[$key], $this->config($field));
            }
        }
    }
}
