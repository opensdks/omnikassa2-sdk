<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model\request;

use DateTime;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\ProductType;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SigningKey;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\VatCategory;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model\request\MerchantOrderRequestBuilder;
use PHPUnit_Framework_TestCase;

class MerchantOrderRequestTest extends PHPUnit_Framework_TestCase
{
    public function testJsonEncoding_withoutOptionalFields()
    {
        $merchantOrderRequest = MerchantOrderRequestBuilder::makeMinimalRequest();
        $merchantOrderRequest->setTimestamp($this->createTimestamp());
        $this->setSignature($merchantOrderRequest);
        $expectedJson = json_encode(array(
            'timestamp' => '2016-12-21T14:13:56+01:00',
            'merchantOrderId' => '100',
            'amount' => array('currency' => 'EUR', 'amount' => 9999),
            'merchantReturnURL' => 'http://localhost/',
            'signature' => '36d5f1890af8407e39eddc9bddfcadce8b3e38707a6a416d52aef3d8c2ab76b3a1155457321ee3370ca0b2339f1894cd94e88c6d6fa013599a22be638c9fda4c'
        ));

        $actualJson = json_encode($merchantOrderRequest);

        $this->assertEquals($expectedJson, $actualJson);
    }

    public function testExceptionIsThrownForInvalidProperty() {
        $this->setExpectedException('InvalidArgumentException');

        MerchantOrder::createFrom(['merchanOrderId' => 'test']);
    }

    public function testJsonEncoding_allFields()
    {
        $merchantOrderRequest = MerchantOrderRequestBuilder::makeCompleteRequest();
        $merchantOrderRequest->setTimestamp($this->createTimestamp());
        $this->setSignature($merchantOrderRequest);
        $expectedJson = json_encode(array(
            'timestamp' => '2016-12-21T14:13:56+01:00',
            'merchantOrderId' => '100',
            'description' => 'Order ID: 100',
            'orderItems' => array(
                array('id' => '15', 'name' => 'Name', 'description' => 'Description', 'quantity' => 1, 'amount' => array('currency' => 'EUR', 'amount' => 100), 'tax' => array('currency' => 'EUR', 'amount' => 50), 'category' => ProductType::DIGITAL, 'vatCategory' => VatCategory::LOW)
            ),
            'amount' => array('currency' => 'EUR', 'amount' => 9999),
            'shippingDetail' => array('firstName' => 'Jan', 'middleName' => 'van', 'lastName' => 'Veen', 'street' => 'Voorbeeldstraat', 'houseNumber' => '5', 'houseNumberAddition' => 'a', 'postalCode' => '1234AB', 'city' => 'Haarlem', 'countryCode' => 'NL'),
            'billingDetail' => array('firstName' => 'Piet', 'middleName' => 'van der', 'lastName' => 'Stoel', 'street' => 'Dorpsstraat', 'houseNumber' => '9', 'houseNumberAddition' => 'rood', 'postalCode' => '4321YZ', 'city' => 'Bennebroek', 'countryCode' => 'NL'),
            'customerInformation' => array('emailAddress' => 'jan.van.veen@gmail.com', 'dateOfBirth' => '20-03-1987', 'gender' => 'M', 'initials' => 'J.M.', 'telephoneNumber' => '0204971111'),
            'language' => 'NL',
            'merchantReturnURL' => 'http://localhost/',
            'paymentBrand' => 'IDEAL',
            'paymentBrandForce' => 'FORCE_ONCE',
            'signature' => '0712c403c89ae92f7531aea31280eb517e274c93c2196e905415407c0dc4bd71e7f0048720ae70d00303da8551485c6444c0f5ddf215ebeb7af4e34580a1af61'
        ));

        $actualJson = json_encode($merchantOrderRequest);

        $this->assertEquals($expectedJson, $actualJson);
    }

    public function testJsonEncoding_withOrderItemsWithoutOptionalFields()
    {
        $merchantOrderRequest = MerchantOrderRequestBuilder::makeWithOrderItemsWithoutOptionalFieldsRequest();
        $merchantOrderRequest->setTimestamp($this->createTimestamp());
        $this->setSignature($merchantOrderRequest);
        $expectedJson = json_encode(array(
            'timestamp' => '2016-12-21T14:13:56+01:00',
            'merchantOrderId' => '100',
            'orderItems' => array(
                array('name' => 'Name', 'description' => 'Description', 'quantity' => 1, 'amount' => array('currency' => 'EUR', 'amount' => 100), 'category' => ProductType::DIGITAL)
            ),
            'amount' => array('currency' => 'EUR', 'amount' => 9999),
            'merchantReturnURL' => 'http://localhost/',
            'signature' => '765b966304f7e6d4f4c1dd5b684175a7f193eb282c27462d6e1c2c170d7d0db84c0136d06082bf4d62f12bbabb8a54abc64c2106016f041ec1c0ef2e599ac659'
        ));

        $actualJson = json_encode($merchantOrderRequest);

        $this->assertEquals($expectedJson, $actualJson);
    }

    public function testJsonEncoding_withShippingDetailsWithoutOptionalFields()
    {
        $merchantOrderRequest = MerchantOrderRequestBuilder::makeWithShippingDetailsWithoutOptionalFieldsRequest();
        $merchantOrderRequest->setTimestamp($this->createTimestamp());
        $this->setSignature($merchantOrderRequest);
        $expectedJson = json_encode(array(
            'timestamp' => '2016-12-21T14:13:56+01:00',
            'merchantOrderId' => '100',
            'amount' => array('currency' => 'EUR', 'amount' => 9999),
            'shippingDetail' => array('firstName' => 'Jan', 'middleName' => 'van', 'lastName' => 'Veen', 'street' => 'Voorbeeldstraat', 'houseNumber' => '5', 'houseNumberAddition' => 'a', 'postalCode' => '1234AB', 'city' => 'Haarlem', 'countryCode' => 'NL'),
            'merchantReturnURL' => 'http://localhost/',
            'signature' => '7a20d5896b7a379168da08bbce2fd9d02dde7fdc7c9963728c6f83d79d36477c797df89e14544210f746c666d14587f9724fe09df6cd8ff228d1d2c8e2480e8f'
        ));

        $actualJson = json_encode($merchantOrderRequest);

        $this->assertEquals($expectedJson, $actualJson);
    }

    public function testJsonEncoding_withPaymentBrandButWithoutOtherOptionalFields()
    {
        $merchantOrderRequest = MerchantOrderRequestBuilder::makeWithPaymentBrandButWithoutOtherOptionalFields();
        $merchantOrderRequest->setTimestamp($this->createTimestamp());
        $this->setSignature($merchantOrderRequest);
        $expectedJson = json_encode(array(
            'timestamp' => '2016-12-21T14:13:56+01:00',
            'merchantOrderId' => '100',
            'amount' => array('currency' => 'EUR', 'amount' => 9999),
            'merchantReturnURL' => 'http://localhost/',
            'paymentBrand' => 'IDEAL',
            'paymentBrandForce' => 'FORCE_ONCE',
            'signature' => '7b847bba5c597d27028463f771109305c9c546f8702463f9a253b7be1b8edae98223bf272d1beba21e7a35015b93bf3dd9b205cd8b73d6a024a096945ecc4f34'
        ));

        $actualJson = json_encode($merchantOrderRequest);

        $this->assertEquals($expectedJson, $actualJson);
    }

    private function setSignature(MerchantOrderRequest $merchantOrderRequest)
    {
        $merchantOrderRequest->calculateAndSetSignature(new SigningKey('secret'));
    }

    /**
     * @return DateTime
     */
    private function createTimestamp()
    {
        return new DateTime('2016-12-21T14:13:56+01:00');
    }
}
