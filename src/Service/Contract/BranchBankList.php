<?php

namespace Morton\Chinaums\Service\Contract;

use Morton\Chinaums\Service\Contract\Base;

/**
 * 所属支行查询接口
 */
class BranchBankList extends Base
{
    /**
     * @var string 接口地址
     */
    protected $api = '/self-contract-nmrs/interface/autoReg';
    /**
     * @var array $body 请求参数
     */
    protected $body = [
        'service' => 'branch_bank_list',
        'sign_type' => 'SHA-256',
    ];
    /**
     * 必传的值
     * @var array
     */
    protected $require = ['service', 'accesser_id', 'sign_type', 'request_date', 'request_seq','areaCode','key'];

}
