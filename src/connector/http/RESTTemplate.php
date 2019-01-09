<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\connector\http;
use JsonSerializable;

/**
 * This interface defines the functionality required to send and receive data to a URL.
 *
 * @package nl\rabobank\gict\payments_savings\omnikassa_sdk\connector\http
 */
interface RESTTemplate
{
    /**
     * Set the token to be used for the upcoming requests.
     *
     * @param string $token
     */
    public function setToken($token);

    /**
     * Perform a GET call to the given path.
     *
     * @param string $path
     * @param array $parameters
     * @return string Response body
     */
    public function get($path, $parameters = []);

    /**
     * Perform a POST call to the given path.
     *
     * @param string $path
     * @param JsonSerializable $body
     * @return string Response body
     */
    public function post($path, JsonSerializable $body = null);
}