<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\connector\http;

use GuzzleHttp\Client;
use JsonSerializable;

/**
 * Guzzle implementation of the RESTTemplate
 *
 * @package nl\rabobank\gict\payments_savings\omnikassa_sdk\connector\http
 */
class GuzzleRESTTemplate implements RESTTemplate
{
    /** @var Client */
    private $client;
    /** @var string */
    private $token;

    /**
     * GuzzleRESTTemplate constructor.
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->client = new Client([
            'base_uri' => $this->parse($baseUrl)
        ]);
    }

    /**
     * @param string $baseUrl
     * @return string
     */
    private function parse($baseUrl)
    {
        if (substr($baseUrl, -1) !== '/') {
            return $baseUrl . '/';
        }
        return $baseUrl;
    }

    /**
     * Set the token to be used for the upcoming requests.
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Perform a GET call to the given path.
     *
     * @param string $path
     * @param array $parameters
     * @return string Response body
     */
    public function get($path, $parameters = [])
    {
        $response = $this->client->get($path, [
            'headers' => $this->makeRequestHeaders(),
            'query' => $parameters
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * Perform a POST call to the given path.
     *
     * @param string $path
     * @param JsonSerializable $body
     * @return string Response body
     */
    public function post($path, JsonSerializable $body = null)
    {
        $response = $this->client->post($path, [
            'headers' => $this->makeRequestHeaders(),
            'json' => $body,
            'expect' => false
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * @return array
     */
    private function makeRequestHeaders()
    {
        return ['Authorization' => 'Bearer ' . $this->token];
    }
}