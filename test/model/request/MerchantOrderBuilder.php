<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model\request;

use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Address;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\CustomerInformation;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Money;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\PaymentBrand;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\PaymentBrandForce;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\request\MerchantOrder;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\test\model\OrderItemBuilder;

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
        $orderItems = array(OrderItemBuilder::makeOrderItemWithoutOptionals());
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
        $shippingDetails = new Address('Developer', null, 'Ximedes', 'Lichtfabriekplein', '2031TE', 'Haarlem', 'NL', '1');
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
        $orderItems = array(OrderItemBuilder::makeCompleteOrderItem());
        $amount = Money::fromDecimal('EUR', 99.99);
        $shippingDetails = new Address('Developer', 'van', 'Ximedes', 'Lichtfabriekplein', '2031TE', 'Haarlem', 'NL', '1', 'a');
        $billingDetails = new Address('Developer', 'van', 'Ximedes', 'Donkerfabriekplein', '3120ET', 'Amsterdam', 'NL', '2', 'a');
        $customerInformation = new CustomerInformation('developer@ximedes.com', '05-11-1987', 'F', 'D.X.', '0204971111');
        $language = 'NL';
        $merchantReturnUrl = 'http://localhost/';
        $paymentBrand = PaymentBrand::IDEAL;
        $paymentBrandForce = PaymentBrandForce::FORCE_ONCE;

        return new MerchantOrder($merchantOrderId, $description, $orderItems, $amount, $shippingDetails, $language, $merchantReturnUrl, $paymentBrand, $paymentBrandForce, $customerInformation, $billingDetails);
    }
}