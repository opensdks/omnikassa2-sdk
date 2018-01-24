<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model;

use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Address;
use PHPUnit_Framework_TestCase;

class AddressTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $address = $this->makeFullAddress();

        $this->assertEquals('firstName', $address->getFirstName());
        $this->assertEquals('middleName', $address->getMiddleName());
        $this->assertEquals('lastName', $address->getLastName());
        $this->assertEquals('street', $address->getStreet());
        $this->assertEquals('postalCode', $address->getPostalCode());
        $this->assertEquals('city', $address->getCity());
        $this->assertEquals('countryCode', $address->getCountryCode());
        $this->assertEquals('houseNumber', $address->getHouseNumber());
        $this->assertEquals('houseNumberAddition', $address->getHouseNumberAddition());
    }

    public function testSignatureData()
    {
        $expectedSignatureData = ['firstName', 'middleName', 'lastName', 'street', 'houseNumber', 'houseNumberAddition', 'postalCode', 'city', 'countryCode'];
        $address = $this->makeFullAddress();
        $actualSignatureData = $address->getSignatureData();

        $this->assertEquals($expectedSignatureData, $actualSignatureData);
    }

    public function testSignatureData_withNullValues()
    {
        $expectedSignatureData = ['firstName', null, 'lastName', 'street', 'postalCode', 'city', 'countryCode'];
        $address = $this->makeSmallAddress();
        $actualSignatureData = $address->getSignatureData();

        $this->assertEquals($expectedSignatureData, $actualSignatureData);
    }

    public function testJsonSerialize()
    {
        $expectedJson = [
            "firstName" => 'firstName',
            "middleName" => 'middleName',
            "lastName" => 'lastName',
            "street" => 'street',
            "houseNumber" => 'houseNumber',
            "houseNumberAddition" => 'houseNumberAddition',
            "postalCode" => 'postalCode',
            "city" => 'city',
            "countryCode" => 'countryCode'
        ];
        $address = $this->makeFullAddress();
        $actualJson = $address->jsonSerialize();

        $this->assertEquals($expectedJson, $actualJson);
    }

    public function testJsonSerialize_withNullValues()
    {
        $expectedJson = [
            "firstName" => 'firstName',
            "lastName" => 'lastName',
            "street" => 'street',
            "postalCode" => 'postalCode',
            "city" => 'city',
            "countryCode" => 'countryCode'
        ];
        $address = $this->makeSmallAddress();
        $actualJson = $address->jsonSerialize();

        $this->assertEquals($expectedJson, $actualJson);
    }

    /**
     * @return Address
     */
    private function makeFullAddress()
    {
        return new Address('firstName', 'middleName', 'lastName', 'street', 'postalCode', 'city', 'countryCode', 'houseNumber', 'houseNumberAddition');
    }

    /**
     * @return Address
     */
    private function makeSmallAddress()
    {
        return new Address('firstName', null, 'lastName', 'street', 'postalCode', 'city', 'countryCode');
    }
}