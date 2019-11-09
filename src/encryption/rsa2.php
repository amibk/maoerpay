<?php


namespace MaoerPay;


class rsa2
{
    //RSA私钥
    public static $PRIVATE_KEY = "";

    //RSA公钥
    public static $PUBLIC_KEY  = "";

    /**
     * 获取私钥
     * @return bool|resource
     */
    private static function getPrivateKey()
    {
        $str = self::$PRIVATE_KEY;
        $str        = chunk_split($str, 64, "\n");
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n$str-----END RSA PRIVATE KEY-----\n";
        return $private_key;
//        $str = self::$PRIVATE_KEY;
//        $privKey =self::$PRIVATE_KEY;;
//        return openssl_pkey_get_private($privKey);
    }
    /**
     * 获取公钥
     * @return bool|resource
     */
    private static function getPublicKey()
    {
        $str = self::$PUBLIC_KEY;
        $str        = chunk_split($str, 64, "\n");
        $publicKey = "-----BEGIN PUBLIC KEY-----\n$str-----END PUBLIC KEY-----\n";
        return $publicKey;
//        $publicKey = self::$PUBLIC_KEY;
//        return openssl_pkey_get_public($publicKey);
    }
    /**
     * 创建签名
     * @param string $data 数据
     * @return null|string
     */
    public static function createSign($data = '')
    {
        //  var_dump(self::getPrivateKey());die;
        if (!is_string($data)) {
            return null;
        }
//        $tmp = self::getPrivateKey();
//        $PRIVATE_KEY
//        return $tmp;
        return openssl_sign($data, $sign, self::getPrivateKey(),OPENSSL_ALGO_SHA256 ) ? base64_encode($sign) : null;
    }
    /**
     * 验证签名
     * @param string $data 数据
     * @param string $sign 签名
     * @return bool
     */
    public static function verifySign($data = '', $sign = '')
    {
        if (!is_string($sign) || !is_string($sign)) {
            return false;
        }
        return (bool)openssl_verify(
            $data,
            base64_decode($sign),
            self::getPublicKey(),
            OPENSSL_ALGO_SHA256
        );
    }
}