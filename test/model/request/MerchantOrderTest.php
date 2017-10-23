<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model\request;

use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Money;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\OrderItem;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\PaymentBrand;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\PaymentBrandForce;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\ShippingDetails;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model\request\MerchantOrderBuilder;
use PHPUnit_Framework_TestCase;

class MerchantOrderTest extends PHPUnit_Framework_TestCase
{
    public function testSerialization_optionalFields()
    {
        $minimalOrder = MerchantOrderBuilder::makeMinimalOrder();

        $expectedJsonSerialize = array(
            'merchantOrderId' => '100',
            'amount' => Money::fromDecimal('EUR', 99.99),
            'merchantReturnURL' => 'http://localhost/'
        );
        $expectedSignatureData = array(
            '100', array('EUR', 9999), null, null, 'http://localhost/'
        );

        $jsonSerialize = $minimalOrder->jsonSerialize();
        $signatureData = $minimalOrder->getSignatureData();

        $this->assertEquals($expectedJsonSerialize, $jsonSerialize);
        $this->assertEquals($expectedSignatureData, $signatureData);
    }

    public function testSerialization_allFields()
    {
        $completeOrder = MerchantOrderBuilder::makeCompleteOrder();

        $expectedJsonSerialize = array(
            'merchantOrderId' => '100',
            'description' => 'Order ID: 100',
            'orderItems' => array(new OrderItem('Test product', 'Description', 1, Money::fromDecimal('EUR', 99.99), Money::fromDecimal('EUR', 4.99), 'PHYSICAL')),
            'amount' => Money::fromDecimal('EUR', 99.99),
            'shippingDetail' => new ShippingDetails('Developer', 'van', 'Ximedes', 'Lichtfabriekplein 1', '2031TE', 'Haarlem', 'NL'),
            'language' => 'NL',
            'merchantReturnURL' => 'http://localhost/',
            'paymentBrand' => 'IDEAL',
            'paymentBrandForce' => 'FORCE_ONCE'
        );
        $expectedSignatureData = array(
            '100',
            array('EUR', 9999),
            'NL',
            'Order ID: 100',
            'http://localhost/',
            array(array('Test product', 'Description', 1, array('EUR', 9999), array('EUR', 499), 'PHYSICAL')),
            array('Developer', 'van', 'Ximedes', 'Lichtfabriekplein 1', '2031TE', 'Haarlem', 'NL'),
            'IDEAL',
            'FORCE_ONCE'
        );

        $jsonSerialize = $completeOrder->jsonSerialize();
        $signatureData = $completeOrder->getSignatureData();

        $this->assertEquals($expectedJsonSerialize, $jsonSerialize);
        $this->assertEquals($expectedSignatureData, $signatureData);
    }

    public function testSerialization_OrderItemsOptionalFields()
    {
        $orderWithOrderItemWithoutOptionalFields = MerchantOrderBuilder::makeWithOrderItemsWithoutOptionalFields();

        $expectedJsonSerialize = array(
            'merchantOrderId' => '100',
            'orderItems' => array(new OrderItem('Test product', 'Description', 1, Money::fromDecimal('EUR', 99.99), null, 'PHYSICAL')),
            'amount' => Money::fromDecimal('EUR', 99.99),
            'merchantReturnURL' => 'http://localhost/',
        );
        $expectedSignatureData = array(
            '100',
            array('EUR', 9999),
            null,
            null,
            'http://localhost/',
            array(array('Test product', 'Description', 1, array('EUR', 9999), null, 'PHYSICAL')),
        );

        $jsonSerialize = $orderWithOrderItemWithoutOptionalFields->jsonSerialize();
        $signatureData = $orderWithOrderItemWithoutOptionalFields->getSignatureData();

        $this->assertEquals($expectedJsonSerialize, $jsonSerialize);
        $this->assertEquals($expectedSignatureData, $signatureData);
    }

    public function testSerialization_ShippingDetailsOptionalFields()
    {
        $orderWithShippingDetailsWithoutOptionalFields = MerchantOrderBuilder::makeWithShippingDetailsWithoutOptionalFields();

        $expectedJsonSerialize = array(
            'merchantOrderId' => '100',
            'amount' => Money::fromDecimal('EUR', 99.99),
            'shippingDetail' => new ShippingDetails('Developer', null, 'Ximedes', 'Lichtfabriekplein 1', '2031TE', 'Haarlem', 'NL'),
            'merchantReturnURL' => 'http://localhost/',
        );
        $expectedSignatureData = array(
            '100',
            array('EUR', 9999),
            null,
            null,
            'http://localhost/',
            array('Developer', null, 'Ximedes', 'Lichtfabriekplein 1', '2031TE', 'Haarlem', 'NL')
        );

        $jsonSerialize = $orderWithShippingDetailsWithoutOptionalFields->jsonSerialize();
        $signatureData = $orderWithShippingDetailsWithoutOptionalFields->getSignatureData();

        $this->assertEquals($expectedJsonSerialize, $jsonSerialize);
        $this->assertEquals($expectedSignatureData, $signatureData);
    }

    public function testSerialization_PaymentBrandOptionalField()
    {
        $orderWithPaymentBrandWithoutOptionalFields = MerchantOrderBuilder::makeWithPaymentBrandRestrictionButWithoutOtherOptionalFields(PaymentBrand::PAYPAL, PaymentBrandForce::FORCE_ALWAYS);

        $expectedJsonSerialize = array(
            'merchantOrderId' => '100',
            'amount' => Money::fromDecimal('EUR', 99.99),
            'merchantReturnURL' => 'http://localhost/',
            'paymentBrand' => PaymentBrand::PAYPAL,
            'paymentBrandForce' => PaymentBrandForce::FORCE_ALWAYS
        );
        $expectedSignatureData = array(
            '100',
            array('EUR', 9999),
            null,
            null,
            'http://localhost/',
            'PAYPAL',
            'FORCE_ALWAYS'
        );

        $jsonSerialize = $orderWithPaymentBrandWithoutOptionalFields->jsonSerialize();
        $signatureData = $orderWithPaymentBrandWithoutOptionalFields->getSignatureData();

        $this->assertEquals($expectedJsonSerialize, $jsonSerialize);
        $this->assertEquals($expectedSignatureData, $signatureData);
    }
}
