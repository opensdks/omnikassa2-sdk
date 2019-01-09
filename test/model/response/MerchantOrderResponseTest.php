<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model\response;


use ErrorException;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SigningKey;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model\response\MerchantOrderResponseBuilder;
use PHPUnit_Framework_TestCase;

class MerchantOrderResponseTest extends PHPUnit_Framework_TestCase
{
    public function testThatObjectIsCorrectlyConstructed()
    {
        $merchantOrderResponse = MerchantOrderResponseBuilder::newInstance();

        $this->assertEquals("http://localhost/redirect/url", $merchantOrderResponse->getRedirectUrl());
    }

    /**
     * @expectedException ErrorException
     * @expectedExceptionMessage The signature validation of the response failed. Please contact the Rabobank service team.
     */
    public function testThatInvalidSignatureExceptionIsThrownWhenTheSignaturesDoNotMatch()
    {
        $response = MerchantOrderResponseBuilder::invalidSignatureInstance();
        $response->validateSignature(new SigningKey('secret'));
    }
}
