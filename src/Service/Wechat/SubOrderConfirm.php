<?php

namespace Morton\Chinaums\Service\Wechat;

use Morton\Chinaums\Service\Wechat\Base;

/**
 * 异步分账确认
 */
class SubOrderConfirm extends Base
{
    /**
     * @var string 接口地址
     */
    protected $api = '/netpay/sub-orders-confirm';
    /**
     * @var array $body 请求参数
     */
    protected $body = [
    ];
    /**
     * 必传的值
     * @var array
     */
    protected $require = ['requestTimestamp', 'merOrderId', 'mid', 'tid','instMid','platformAmount'];
}
