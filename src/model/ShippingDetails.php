<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;

use JsonSerializable;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SignatureDataProvider;

/**
 * @package nl\rabobank\gict\payments_savings\omnikassa_sdk\model
 */
class ShippingDetails implements JsonSerializable, SignatureDataProvider
{
    /** @var string */
    protected $firstName;
    /** @var string */
    protected $middleName;
    /** @var string */
    protected $lastName;
    /** @var string */
    protected $street;
    /** @var string */
    protected $postalCode;
    /** @var string */
    protected $city;
    /** @var string */
    protected $countryCode;

    /**
     * @param string $firstName
     * @param string $middleName
     * @param string $lastName
     * @param string $street
     * @param string $postalCode
     * @param string $city
     * @param string $countryCode
     */
    public function __construct($firstName, $middleName, $lastName, $street, $postalCode, $city, $countryCode)
    {
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
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
            $this->firstName,
            $this->middleName,
            $this->lastName,
            $this->street,
            $this->postalCode,
            $this->city,
            $this->countryCode
        );
    }
}