<?php

namespace Morton\Chinaums\Service\Wechat;

use Morton\Chinaums\Service\Wechat\Base;

/**
 * 退款查询接口
 */
class RefundQuery extends Base
{
    /**
     * @var string 接口地址
     */
    protected $api = '/netpay/refund-query';
    /**
     * @var array $body 请求参数
     */
    protected $body = [
    ];
    /**
     * 必传的值
     * @var array
     */
    protected $require = ['requestTimestamp', 'merOrderId', 'mid', 'tid','instMid'];
}
