<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing;

/**
 * This interface describes what each signature data provider must provide to be able to calculate the signature.
 *
 * @package nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing
 */
interface SignatureDataProvider
{
    /**
     * @return array
     */
    function getSignatureData();
}