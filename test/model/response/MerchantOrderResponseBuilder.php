<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model\response;


use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\response\MerchantOrderResponse;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SigningKey;

class MerchantOrderResponseBuilder
{
    /**
     * @return MerchantOrderResponse
     */
    public static function newInstance()
    {
        return new MerchantOrderResponse(json_encode(self::getData()), self::getSigningKey());
    }

    /**
     * @return MerchantOrderResponse
     */
    public static function invalidSignatureInstance()
    {
        $testData = self::getData();
        $testData["redirectUrl"] = "http://some.other.host/redirect/url";

        return new MerchantOrderResponse(json_encode($testData), self::getSigningKey());
    }

    /**
     * @return string
     */
    public static function newInstanceAsJson()
    {
        return json_encode(self::getData());
    }

    /**
     * @return array
     */
    private static function getData()
    {
        return array(
            "redirectUrl" => "http://localhost/redirect/url",
            "signature" => "2b997c845b6f83d8cf90c5c7f0121e727729f9325d0b954ac7ad9e8a4f3cba26931293e96f973f19dffe86628d1312a2c4ccd6dbaae8fd78b30fb0122fbcf8ee"
        );
    }

    /**
     * @return SigningKey
     */
    private static function getSigningKey()
    {
        return new SigningKey('secret');
    }
}