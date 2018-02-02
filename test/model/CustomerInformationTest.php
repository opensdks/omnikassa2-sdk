<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model;

use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\CustomerInformation;
use PHPUnit_Framework_TestCase;

class CustomerInformationTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $customerInformation = $this->makeCompleteCustomerInformation();

        $this->assertEquals('emailAddress', $customerInformation->getEmailAddress());
        $this->assertEquals('dateOfBirth', $customerInformation->getDateOfBirth());
        $this->assertEquals('gender', $customerInformation->getGender());
        $this->assertEquals('initials', $customerInformation->getInitials());
        $this->assertEquals('telephoneNumber', $customerInformation->getTelephoneNumber());
    }

    public function testSignatureData()
    {
        $expectedSignatureData = [
            'emailAddress',
            'dateOfBirth',
            'gender',
            'initials',
            'telephoneNumber'
        ];
        $customerInformation = $this->makeCompleteCustomerInformation();
        $actualSignatureData = $customerInformation->getSignatureData();

        $this->assertEquals($expectedSignatureData, $actualSignatureData);
    }

    public function testSignatureData_withNullValues()
    {
        $expectedSignatureData = [
            null,
            null,
            null,
            null,
            null
        ];
        $customerInformation = $this->makeCustomerInformationWithoutOptionals();
        $actualSignatureData = $customerInformation->getSignatureData();

        $this->assertEquals($expectedSignatureData, $actualSignatureData);
    }

    public function testJsonSerialize()
    {
        $expectedJson = [
            "emailAddress" => 'emailAddress',
            "dateOfBirth" => 'dateOfBirth',
            "gender" => 'gender',
            "initials" => 'initials',
            "telephoneNumber" => 'telephoneNumber'
        ];
        $customerInformation = $this->makeCompleteCustomerInformation();
        $actualJson = $customerInformation->jsonSerialize();

        $this->assertEquals($expectedJson, $actualJson);
    }

    public function testJsonSerialize_withNullValues()
    {
        $expectedJson = [];
        $customerInformation = $this->makeCustomerInformationWithoutOptionals();
        $actualJson = $customerInformation->jsonSerialize();

        $this->assertEquals($expectedJson, $actualJson);
    }

    /**
     * @return CustomerInformation
     */
    private function makeCompleteCustomerInformation()
    {
        return new CustomerInformation('emailAddress', 'dateOfBirth', 'gender', 'initials', 'telephoneNumber');
    }

    /**
     * @return CustomerInformation
     */
    private function makeCustomerInformationWithoutOptionals()
    {
        return new CustomerInformation(null, null, null, null, null);
    }
}