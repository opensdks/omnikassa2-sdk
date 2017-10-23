<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;

use JsonSerializable;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SignatureDataProvider;

/**
 * @package nl\rabobank\gict\payments_savings\omnikassa_sdk\model
 */
class Money implements JsonSerializable, SignatureDataProvider
{
    /** @var string */
    private $currency;
    /** @var int */
    private $amount;

    /**
     * Construct a Money object with the given currency and the amount in cents.
     *
     * @param string $currency
     * @param int $amount in cents.
     * @return Money
     */
    public static function fromCents($currency, $amount)
    {
        $money = new Money();
        $money->setCurrency($currency);
        $money->setAmount($amount);
        return $money;
    }

    /**
     * Construct a Money object with the given currency and the amount in decimals.
     *
     * @param string $currency
     * @param float $amount
     * @return Money
     */
    public static function fromDecimal($currency, $amount)
    {
        $roundedAmount = round($amount, 2);

        $money = new Money();
        $money->setCurrency($currency);
        $money->setAmount($roundedAmount * 100);

        return $money;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return array("currency" => $this->currency, "amount" => $this->amount);
    }

    /**
     * @return string
     */
    function __toString()
    {
        return ($this->amount / 100) . ' ' . $this->currency;
    }

    public function getSignatureData()
    {
        return array($this->currency, $this->amount);
    }
}