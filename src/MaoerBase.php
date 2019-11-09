<?php

namespace maoerpay;

use maoerpay\rsa2;
/**
 * 猫耳支付基类
 * Class MaoerBase
 */

class MaoerBase
{

    /**
     * CURL访问
     * @param $url
     * @param bool $params
     * @param int $ispost
     * @param array $header
     * @param bool $verify
     * @return bool|string
     */
    protected function http($url, $params = false, $ispost = 0, $header = [], $verify = false) {
        $httpInfo = array();
        $ch = curl_init();
        if(!empty($header)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //忽略ssl证书
        if($verify === true){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if (is_array($params)) {
                $params = http_build_query($params);
            }
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * 计算签名
     * @param array $params
     * @return string|null
     */
    protected function sign($params = []){
        $str = $this->ToSignParams($params);
        $sign = rsa2::createSign($str);
        return $sign;
    }

    /**
     * 参数合并获得待签名数据
     * @param $value
     * @return string
     */
    private function ToSignParams($value)
    {
        $buff = "";
        foreach ($value as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }
}
