<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;

use PHPUnit_Framework_TestCase;

class ShippingDetailsTest extends PHPUnit_Framework_TestCase
{
    public function testMiddleName_ShouldBeNullable()
    {
        $expectedJsonSerialize = array(
            'firstName' => 'FirstName',
            'lastName' => 'LastName',
            'street' => 'Street',
            'postalCode' => 'PostalCode',
            'city' => 'City',
            'countryCode' => 'CountryCode'
        );
        $expectedSignatureData = array(
            'FirstName',
            null,
            'LastName',
            'Street',
            'PostalCode',
            'City',
            'CountryCode'
        );

        $shippingDetails = new ShippingDetails('FirstName', null, 'LastName', 'Street', 'PostalCode', 'City', 'CountryCode');

        $jsonSerialize = $shippingDetails->jsonSerialize();
        $signatureData = $shippingDetails->getSignatureData();

        $this->assertEquals($expectedJsonSerialize, $jsonSerialize);
        $this->assertEquals($expectedSignatureData, $signatureData);
    }
}
