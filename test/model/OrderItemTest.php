<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;

use PHPUnit_Framework_TestCase;

class OrderItemTest extends PHPUnit_Framework_TestCase
{
    public function testTax_ShouldBeNullable()
    {
        $expectedJsonSerialize = array(
            'name' => 'Name',
            'description' => 'Description',
            'quantity' => 1,
            'amount' => Money::fromCents('EUR', 100),
            'category' => 'Category'
        );
        $expectedSignatureData = array(
            'Name',
            'Description',
            1,
            array('EUR', 100),
            null,
            'Category'
        );

        $orderItem = new OrderItem('Name', 'Description', 1, Money::fromCents('EUR', 100), null, 'Category');

        $jsonSerialize = $orderItem->jsonSerialize();
        $signatureData = $orderItem->getSignatureData();

        $this->assertEquals($expectedJsonSerialize, $jsonSerialize);
        $this->assertEquals($expectedSignatureData, $signatureData);
    }
}
