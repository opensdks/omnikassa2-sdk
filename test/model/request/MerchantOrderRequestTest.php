<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model\request;

use DateTime;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SigningKey;
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
                array('name' => 'Test product', 'description' => 'Description', 'quantity' => 1, 'amount' => array('currency' => 'EUR', 'amount' => 9999), 'tax' => array('currency' => 'EUR', 'amount' => 499), 'category' => 'PHYSICAL')
            ),
            'amount' => array('currency' => 'EUR', 'amount' => 9999),
            'shippingDetail' => array('firstName' => 'Developer', 'middleName' => 'van', 'lastName' => 'Ximedes', 'street' => 'Lichtfabriekplein 1', 'postalCode' => '2031TE', 'city' => 'Haarlem', 'countryCode' => 'NL'),
            'language' => 'NL',
            'merchantReturnURL' => 'http://localhost/',
            'paymentBrand' => 'IDEAL',
            'paymentBrandForce' => 'FORCE_ONCE',
            'signature' => 'b2b4df382b99d046954fe0f4d55a9ccad5fcb9ae0d9a941f9b38d196fcbe42f4989921b3f353e1fc80bfccec84419b348f898fc805338784ee7226f1e779b15f'
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
                array('name' => 'Test product', 'description' => 'Description', 'quantity' => 1, 'amount' => array('currency' => 'EUR', 'amount' => 9999), 'category' => 'PHYSICAL')
            ),
            'amount' => array('currency' => 'EUR', 'amount' => 9999),
            'merchantReturnURL' => 'http://localhost/',
            'signature' => '20b8ec4bfb3a2a453aa04daa4942de4b67d2e8b0f36521c3fe9f88aebd1c83d3fce7f88be7148dbc4e68a1708da4cba65bf0df568412505557bad57a2742d45b'
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
            'shippingDetail' => array('firstName' => 'Developer', 'lastName' => 'Ximedes', 'street' => 'Lichtfabriekplein 1', 'postalCode' => '2031TE', 'city' => 'Haarlem', 'countryCode' => 'NL'),
            'merchantReturnURL' => 'http://localhost/',
            'signature' => '0d06362272d8625220302b4dcb0ed4ffed90e9092a2c2c1e36a311cc747a4ac9fbba65f0efe994655ee550e6e633636ec4f54b00c2a5c0cb6f0ef5bc82cb9dca'
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
