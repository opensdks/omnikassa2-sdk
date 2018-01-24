<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;

use JsonSerializable;
use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SignatureDataProvider;

/**
 * This class defines the customer information.
 */
class CustomerInformation implements JsonSerializable, SignatureDataProvider
{
    /** @var string */
    private $emailAddress;
    /** @var string */
    private $dateOfBirth;
    /** @var string */
    private $gender;
    /** @var string */
    private $initials;
    /** @var string */
    private $telephoneNumber;

    /**
     * @param string $emailAddress
     * @param string $dateOfBirth
     * @param string $gender
     * @param string $initials
     * @param string $telephoneNumber
     */
    public function __construct($emailAddress, $dateOfBirth, $gender, $initials, $telephoneNumber)
    {
        $this->emailAddress = $emailAddress;
        $this->dateOfBirth = $dateOfBirth;
        $this->gender = $gender;
        $this->initials = $initials;
        $this->telephoneNumber = $telephoneNumber;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * @return string
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }

    /**
     * @return array
     */
    public function getSignatureData()
    {
        return array(
            $this->emailAddress,
            $this->dateOfBirth,
            $this->gender,
            $this->initials,
            $this->telephoneNumber
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
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