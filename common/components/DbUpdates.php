<?php

namespace common\components;


use yii\base\Component;
use yii\di\Instance;
use yii\helpers\Json;
use yii\redis\Connection;

class DbUpdates extends Component
{

    /** @var \yii\redis\Connection */
    public $redis = 'redis';

    public function init()
    {
        parent::init();

        $this->redis = Instance::ensure($this->redis, Connection::className());
    }

    public function emit($entity, $event, $data = null)
    {
        $this->redis->publish('DbUpdates', Json::encode([
            'name' => "{$entity}.{$event}",
            'data' => $data
        ]));
    }
}