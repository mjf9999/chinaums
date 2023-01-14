<?php

namespace Morton\Chinaums\Provider;

use Morton\Chinaums\Interfaces\ProviderInterface;
use Morton\Chinaums\Tools\Verify;
use Morton\Chinaums\Tools\Str;

use Exception;

class Wechat implements ProviderInterface
{
    protected $config = [];
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function __call(string $shortcut, array $params)
    {
        $class = '\\Morton\\Chinaums\\Service\\Wechat\\' . Str::studly($shortcut);
        $objcet = new $class();
        $objcet->setConfig($this->config);
        return $objcet;
    }

    public function pay($order)
    {
        return $this->__call('Mini', [])->request($order);
    }

    public function find($order)
    {
        return $this->__call('Query', [])->request($order);
    }

    public function cancel($order)
    {
        throw new Exception("Wechat does not support cancel api");
    }

    public function close($order)
    {
        return $this->__call('Close', [])->request($order);
    }

    public function refund($order)
    {
        return $this->__call('Refund', [])->request($order);
    }

    public function callback($contents)
    {
        $params = array_map(function ($value) {
            return urldecode($value);
        }, $contents);
        $md5Key = $this->config['md5key'];
        $sign = Verify::makeSign($md5Key, $params);
        $notifySign = array_key_exists('sign', $params) ? $params['sign'] : '';
        if (strcmp($sign, $notifySign) == 0) {
            return true;
        }
        return false;
    }

    public function success()
    {
        return 'SUCCESS';
    }
}
