<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model\request;

use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Money;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\OrderItem;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\PaymentBrand;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\PaymentBrandForce;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\ProductType;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\request\MerchantOrder;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\ShippingDetails;

class MerchantOrderBuilder
{
    public static function makeMinimalOrder()
    {
        $merchantOrderId = '100';
        $description = null;
        $orderItems = null;
        $shippingDetails = null;
        $amount = Money::fromDecimal('EUR', 99.99);
        $language = null;
        $merchantReturnUrl = 'http://localhost/';

        return new MerchantOrder($merchantOrderId, $description, $orderItems, $amount, $shippingDetails, $language, $merchantReturnUrl);
    }

    public static function makeWithOrderItemsWithoutOptionalFields()
    {
        $merchantOrderId = '100';
        $description = null;
        $orderItems = array(new OrderItem('Test product', 'Description', 1, Money::fromDecimal('EUR', 99.99), null, ProductType::PHYSICAL));
        $shippingDetails = null;
        $amount = Money::fromDecimal('EUR', 99.99);
        $language = null;
        $merchantReturnUrl = 'http://localhost/';

        return new MerchantOrder($merchantOrderId, $description, $orderItems, $amount, $shippingDetails, $language, $merchantReturnUrl);
    }

    public static function makeWithShippingDetailsWithoutOptionalFields()
    {
        $merchantOrderId = '100';
        $description = null;
        $orderItems = null;
        $shippingDetails = new ShippingDetails('Developer', null, 'Ximedes', 'Lichtfabriekplein 1', '2031TE', 'Haarlem', 'NL');
        $amount = Money::fromDecimal('EUR', 99.99);
        $language = null;
        $merchantReturnUrl = 'http://localhost/';

        return new MerchantOrder($merchantOrderId, $description, $orderItems, $amount, $shippingDetails, $language, $merchantReturnUrl);
    }

    public static function makeWithPaymentBrandRestrictionButWithoutOtherOptionalFields($paymentBrand, $paymentBrandForce)
    {
        $merchantOrderId = '100';
        $description = null;
        $orderItems = null;
        $shippingDetails = null;
        $amount = Money::fromDecimal('EUR', 99.99);
        $language = null;
        $merchantReturnUrl = 'http://localhost/';

        return new MerchantOrder($merchantOrderId, $description, $orderItems, $amount, $shippingDetails, $language, $merchantReturnUrl, $paymentBrand, $paymentBrandForce);
    }

    public static function makeCompleteOrder()
    {
        $merchantOrderId = '100';
        $description = 'Order ID: ' . $merchantOrderId;
        $orderItems = array(new OrderItem('Test product', 'Description', 1, Money::fromDecimal('EUR', 99.99), Money::fromDecimal('EUR', 4.99), ProductType::PHYSICAL));
        $amount = Money::fromDecimal('EUR', 99.99);
        $shippingDetails = new ShippingDetails('Developer', 'van', 'Ximedes', 'Lichtfabriekplein 1', '2031TE', 'Haarlem', 'NL');
        $language = 'NL';
        $merchantReturnUrl = 'http://localhost/';
        $paymentBrand = PaymentBrand::IDEAL;
        $paymentBrandForce = PaymentBrandForce::FORCE_ONCE;

        return new MerchantOrder($merchantOrderId, $description, $orderItems, $amount, $shippingDetails, $language, $merchantReturnUrl, $paymentBrand, $paymentBrandForce);
    }
}