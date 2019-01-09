<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;

use DateTime;
use InvalidArgumentException;
use JsonSerializable;

class AccessToken implements JsonSerializable
{
    /** @var string */
    private $token;
    /** @var DateTime */
    private $validUntil;
    /** @var int */
    private $durationInMillis;

    /**
     * @param string $token
     * @param DateTime $validUntil
     * @param int $durationInMillis
     */
    public function __construct($token, $validUntil, $durationInMillis)
    {
        if (empty($token)) {
            throw new InvalidArgumentException("Token cannot be empty");
        }
        if (empty($validUntil)) {
            throw new InvalidArgumentException("Valid until cannot be empty");
        }
        if (empty($durationInMillis)) {
            throw new InvalidArgumentException("Duration in milliseconds cannot be empty");
        }
        $this->token = $token;
        $this->validUntil = $validUntil;
        $this->durationInMillis = $durationInMillis;
    }

    /**
     * Construct an access token from the given json.
     *
     * @param string $json
     * @return AccessToken
     */
    public static function fromJson($json)
    {
        $result = json_decode($json, true);
        return new AccessToken($result['token'], new DateTime($result['validUntil']), $result['durationInMillis']);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return DateTime
     */
    public function getValidUntil()
    {
        return $this->validUntil;
    }

    /**
     * @return int
     */
    public function getDurationInMillis()
    {
        return $this->durationInMillis;
    }

    /**
     * @return int
     */
    public function getDurationInSeconds()
    {
        return $this->durationInMillis / 1000;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return array(
            "token" => $this->token,
            "validUntil" => $this->validUntil->format(DateTime::ISO8601),
            "durationInMillis" => $this->durationInMillis
        );
    }
}