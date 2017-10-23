<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;

use JsonSerializable;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SignatureDataProvider;

/**
 * @package nl\rabobank\gict\payments_savings\omnikassa_sdk\model
 */
class OrderItem implements JsonSerializable, SignatureDataProvider
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $description;
    /** @var int */
    protected $quantity;
    /** @var Money */
    protected $amount;
    /** @var Money */
    protected $tax;
    /** @var string */
    protected $category;

    /**
     * @param string $name
     * @param string $description
     * @param int $quantity describes how many of this item the customer ordered
     * @param Money $amount describes the price per item
     * @param Money $tax describes the tax per item
     * @param string $category
     */
    public function __construct($name, $description, $quantity, Money $amount, $tax, $category)
    {
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->amount = $amount;
        $this->tax = $tax;
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return Money
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
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

    public function getSignatureData()
    {
        return array(
            $this->name,
            $this->description,
            $this->quantity,
            $this->amount->getSignatureData(),
            ($this->tax != null ? $this->tax->getSignatureData() : null),
            $this->category
        );
    }
}