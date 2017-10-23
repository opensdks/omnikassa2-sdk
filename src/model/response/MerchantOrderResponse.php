<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model\response;

/**
 * @package nl\rabobank\gict\payments_savings\omnikassa_sdk\model\response
 */
class MerchantOrderResponse extends Response
{
    /** @var string */
    protected $redirectUrl;

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return array
     */
    public function getSignatureData()
    {
        return array($this->redirectUrl);
    }
}