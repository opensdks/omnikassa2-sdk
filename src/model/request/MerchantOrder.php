<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model\request;

use JsonSerializable;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\Money;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\OrderItem;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\ShippingDetails;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SignatureDataProvider;

/**
 * @package nl\rabobank\gict\payments_savings\omnikassa_sdk\model\request
 */
class MerchantOrder implements SignatureDataProvider, JsonSerializable
{
    /** @var string */
    private $merchantOrderId;
    /** @var string */
    private $description;
    /** @var OrderItem[] */
    private $orderItems;
    /** @var Money */
    private $amount;
    /** @var ShippingDetails */
    private $shippingDetail;
    /** @var string */
    private $language;
    /** @var string */
    private $merchantReturnURL;
    /** @var string */
    private $paymentBrand;
    /** @var string */
    private $paymentBrandForce;

    /**
     * @param string $merchantOrderId
     * @param string $description
     * @param OrderItem[] $orderItems
     * @param Money $amount the sum of the order items
     * @param ShippingDetails $shippingDetail
     * @param string $language
     * @param string $merchantReturnURL
     * @param string $paymentBrand
     * @param string $paymentBrandForce
     */
    public function __construct($merchantOrderId,
                                $description,
                                $orderItems,
                                Money $amount,
                                $shippingDetail,
                                $language,
                                $merchantReturnURL,
                                $paymentBrand = null,
                                $paymentBrandForce = null)
    {
        $this->merchantOrderId = $merchantOrderId;
        $this->description = $description;
        $this->orderItems = $orderItems;
        $this->amount = $amount;
        $this->shippingDetail = $shippingDetail;
        $this->language = $language;
        $this->merchantReturnURL = $merchantReturnURL;
        $this->paymentBrand = $paymentBrand;
        $this->paymentBrandForce = $paymentBrandForce;
    }

    /**
     * @return array
     */
    public function getSignatureData()
    {
        $signatureData = array(
            $this->merchantOrderId,
            $this->amount->getSignatureData(),
            $this->language,
            $this->description,
            $this->merchantReturnURL
        );
        if ($this->orderItems != null) {
            $signatureData[] = $this->getOrderItemSignatureData();
        }
        if ($this->shippingDetail != null) {
            $signatureData[] = $this->shippingDetail->getSignatureData();
        }
        if ($this->paymentBrand != null) {
            $signatureData[] = $this->paymentBrand;
        }
        if ($this->paymentBrandForce != null) {
            $signatureData[] = $this->paymentBrandForce;
        }
        return $signatureData;
    }

    private function getOrderItemSignatureData()
    {
        $orderItemsSignatureData = array();
        foreach ($this->orderItems as $orderItem) {
            $orderItemsSignatureData[] = $orderItem->getSignatureData();
        }
        return $orderItemsSignatureData;
    }

    function jsonSerialize()
    {
        $json = array();
        foreach ($this as $key => $value) {
            if ($value != null) {
                $json[$key] = $value;
            }
        }
        return $json;
    }
}