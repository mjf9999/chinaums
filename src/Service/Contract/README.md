# 银联商务 自助签约详细采集接口-基础版-v1.1.13-20220908
3.11之后的接口未测试，使用前请测试
* 支持自助签约采集接口 [点击查看文档](/doc/Contract/%E8%87%AA%E5%8A%A9%E7%AD%BE%E7%BA%A6%E8%AF%A6%E7%BB%86%E9%87%87%E9%9B%86%E6%8E%A5%E5%8F%A3-%E5%9F%BA%E7%A1%80%E7%89%88-v1.1.13-20220908.pdf)
## 新入网接口调用顺序

* 前台接入 3.14->3.4
* 后台接入3.1->3.2->3.7（对公账户打款接口，非对公账户无需调用）->3.6（对公账户金额验证接口，非对公账户无需调用)->3.3->3.4
* 账户变更接口调用顺序 3.1->3.9->3.10->3.11
#### 前台接入示例
```php
// 3.14第一步 获取签约地址
$config = include_once './Config/Config.php';
$data = [
    'request_date' => '20230113100309', //请求时间
    'request_seq' => '574a47ee20404d4ca5bbc65a1e989a82',
    'accesser_acct' => 'd158ca13-5886-45',
];
$platform = 'H5';
// $platform = 'pc';
Factory::config($config);
$reponse = Factory::Contract()->MerchantReg()->setPlatform($platform)->request($data);
// 3.4第二步 入网状态查询接口
$reponse = Factory::Contract()->ApplyQry($data);
```
#### 后台接入示例

```php
// 配置参考前提接入 这里简化调用过程
Factory::config($config);
$reponse = Factory::Contract()->PicUpload($data);//3.1
$reponse = Factory::Contract()->complexUpload($data);//3.2
$reponse = Factory::Contract()->requestAccountVerify($data);//3.7
$reponse = Factory::Contract()->companyAccountVerify($data);//3.6
$reponse = Factory::Contract()->agreementSign($data);//3.3
$reponse = Factory::Contract()->applyQry($data);//3.4

```
#### 账户变更接口调用顺序

```php
// 配置参考前提接入 这里简化调用过程
Factory::config($config);
$reponse = Factory::Contract()->PicUpload();//3.1
$reponse = Factory::Contract()->ComplexAlterAcctinfo()->request($data);//3.9
$reponse = Factory::Contract()->AlterSign()->request($data);//3.10
$reponse = Factory::Contract()->AlterQry()->request($data);//3.11
```
## 使用示例
更多示例可查看[test](../../../test/Contract/)目录下的文件
```php
<?php
include_once '../../vendor/autoload.php';

use Morton\Chinaums\Factory;

date_default_timezone_set('PRC');

$config = [
    // 请求网关  https://yinshangpai.chinaums.com
    'gateway' => 'https://selfapply-test.chinaums.com',
    // 商户号
    'accesser_id' => 'ff80808162dc66840162dc7906da0054',
    // 回调验证需要的md5key
    'private_key' => 'udik876ehjde32dU61edsxsf'
];
$data = [
    'request_date' => '20180827111438',//请求时间
    'pic_base64' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAMAAABiM0N1AAAAmVBMVEUAAAAAygEAygEAzw0A3DIAygEAygEAzQUAygEAygEAygIA0AoAygEAygEAygIAywMAzwgA1BIA/2AAygMA2RsAygEAygEAygIAywIAywQAzAQAywQAywYAygEAygEAygEAyQEAygIAygIAygIAywIAygIAzQcAygEAygEAygEAygIAygIAygIAzAYAywMAywMAzAMAygIAyQFOdEr4AAAAMnRSTlMA+/ETBdm8LtvPchjIwZhOHA0CWwnn4YZ1Rj03JvTt67GhnJGLeSLVt6t+bWcrYVdKppctVJsAAAJbSURBVFjD7dfXmqJAEIbhv8FAEAUUc85Zp+7/4lZ9lBWrEbrZPZv3cEYL+ewGxK9Chs39zLMiQ4hRtKnMV1cX6tbOdkxMe9Y0ocDdbyiNmDZKyKc/FfRV1DHzjPEo2yhzlD+lfIxuiHShM6LcatX0xhVSIVZpdSJStGtB4iJIme2DOQrS0GaTmqSn7CKhJ0iTl9yeI90PdEz0LtmkpXJF0pI0iBlbkSeNQONOXLk6f10OKqTKOsRp3Log5/mNKX9RjTCu2zXuHy/A3VYtzc8AsYZFD6tHIVJgLH3EqnGTdghgqZImQMy8xYn1AJQ/jllLvQBdQiAZJzYHhpQ0QC+SpdkNABYn1gbObBBclt9YrAEW552PBSX94OYgEodzAiAZh+nD+zwH/3HMzVuaUmJfOgZJnGHRhwXuWvXn7bAP8DhcFxN2zzKfb9m80vA4XAf8fFd4eu0nHodbSgZFnwN4HK4DQxZOolGmb/aQ/L8M5pR1qXEge0UjKw7XxII4L0cctiGa0j+zOFlM+NKbOouTwQJgEyeGGXH4MgK6JFHPiMP3LODKDip6wDUjDlswc5IQXo3yO+JuLaigyXNTzaig42vhTqgQO2RPWVrEALEdFbDCXy2btFVCvPG1M9kBEqpsku5j7SkiDdYazLCscV4uJIIpKdoFkOuorZ8DUtWo8M8s1V03PuKbvOvS2Af4xs15GeumjVHZvJNZD5nmrwDdtXld1gR7UPE6/RA5tOlOLEw8lKrN/Xxbs62y7W3rq0s1RB6v59LpEEU5tzGbHoo70/hQwr8QlPDrP/oD+JVFlunvag4AAAAASUVORK5CYII=',
    'request_seq' => '20191111111111111', 
];
Factory::config($config);
$reponse = Factory::Contract()->PicUpload($data);
echo 'response:' . $reponse . PHP_EOL;

```
