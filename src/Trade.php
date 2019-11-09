<?php


namespace maoerpay;

use maoerpay\MaoerBase;
use maoerpay\rsa2;
/**
 * 猫耳支付交易处理
 * Class Trade
 * @package MaoerPay
 */
class Trade extends MaoerBase
{
    //应用私钥
    private $PRIVATE_KEY;
    //商户号
    private $mch_id;

    public function __construct(array $params)
    {
        if (empty($params['mch_id'])){
            return "缺少商户号";
        }elseif (empty($params['PRIVATE_KEY'])){
            return "应用私钥";
        }
        rsa2::$PRIVATE_KEY = $params['PRIVATE_KEY'];
        $this->mch_id = $params['mch_id'];
    }

    public function barpay(array $params){
        $params['mchid'] = $this->mch_id;
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $result = $this->http('https://open.maoer.net.cn/api/trade/barpay',$params,1);
        return $result;
    }
    public function jsapi(array $params){
        if ($params['trade_type'] == "JSAPI" && empty($params['trade_type'])){
            return 'JSAPI支付时，openid为必传参数';
        }elseif ($params['NATIVE'] == "NATIVE" && empty($params['product_id'])){
            return 'NATIVE支付时，product_id为必传参数';
        }
        $params['mchid'] = $this->mch_id;
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $result = $this->http('https://open.maoer.net.cn/api/trade/jspay',$params,1);
        return $result;
    }
    public function order_query(array $params){
        if (empty($params['out_trade_no']) && empty($params['trade_type'])) return 'out_trade_no和maoer_id不能同时为空';
        $params['mchid'] = $this->mch_id;
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $result = $this->http('https://open.maoer.net.cn/api/trade/order_query',$params,1);
        return $result;
    }
    public function order_close(array $params){
        if (empty($params['out_trade_no']))return "请传递要关闭的订单号";
        $params['mchid'] = $this->mch_id;
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $result = $this->http('https://open.maoer.net.cn/api/trade/order_close',$params,1);
        return $result;
    }
    public function order_reverse(array $params){
        if (empty($params['out_trade_no']))return "请传递要撤销的订单号";
        $params['mchid'] = $this->mch_id;
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $result = $this->http('https://open.maoer.net.cn/api/trade/order_reverse',$params,1);
        return $result;
    }
    public function refund(array $params){
        $params['refund_desc'] = empty($params['refund_desc']) ? "正常退款" : $params['refund_desc'];
        $params['mchid'] = $this->mch_id;
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $result = $this->http('https://open.maoer.net.cn/api/trade/refund',$params,1);
        return $result;
    }
    public function refund_query(array $params){
        $params['mchid'] = $this->mch_id;
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $result = $this->http('https://open.maoer.net.cn/api/trade/refund_query',$params,1);
        return $result;
    }
    public function downloadbill(array $params){
        $params['mchid'] = $this->mch_id;
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $result = $this->http('https://open.maoer.net.cn/api/trade/downloadbill',$params,1);
        return $result;
    }
}
