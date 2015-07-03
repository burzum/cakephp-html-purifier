<?php
namespace App\Model\Behavior;

use ArrayObject;
use Burzum\HtmlPurifier\Lib\PurifierTrait;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use HTMLPurifier;
use HTMLPurifier_Config;

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
        foreach ($this->config('fields') as $field) {
            if (isset($data[$field])) {
                $data[$field] = $this->purifyHtml($data[$field], $this->config('purifierConfig'));
            }
        }
    }

    public function purifier($config = null)
    {
//        if (is_string($config)) {
//            $config = (array)Configure::read('HtmlPurifier.' . $config);
//        }
//        if (!is_array($config)) {
//            throw new \InvalidArgumentException('Invalid purifier config value passed!');
//        }
//        $hash = md5(serialize($config));
//        if (!empty($this->_purifier[$hash])) {
//            return $this->_purifier[$hash];
//        }
//        $config = \HTMLPurifier_Config::create($config);
//        $this->_purifier[$hash] = new \HTMLPurifier($config);
//        return $this->_purifier[$hash];
    }
}
