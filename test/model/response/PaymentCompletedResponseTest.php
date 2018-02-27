<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model\response;


use nl\rabobank\gict\payments_savings\omnikassa_sdk\model\signing\SigningKey;
use PHPUnit_Framework_TestCase;

class PaymentCompletedResponseTest extends PHPUnit_Framework_TestCase
{

    public function testThatIsValidReturnsTrueForAValidSignature()
    {
        $signingKey = new SigningKey('secret');
        $paymentCompletedResponse = PaymentCompletedResponse::createInstance('1', 'COMPLETED', 'b890b2f3c6f102bb853ed448dd58d2c13cc695541f5eecca713470e68ced6f2c1a5f5ddd529a732ff51a019126ffefa8bd1d0193b596b393339ffcbf6f335241', $signingKey);
        $this->assertNotFalse($paymentCompletedResponse);
        $this->assertEquals('1', $paymentCompletedResponse->getOrderID());
        $this->assertEquals('COMPLETED', $paymentCompletedResponse->getStatus());
    }

    public function testThatIsValidReturnsFalseForInvalidSignatures()
    {
        $signingKey = new SigningKey('secret');
        $isValid = PaymentCompletedResponse::createInstance('1', 'CANCELLED', 'ffb94fef027526bab3f98eaa432974daea4e743f09de86ab732208497805bb12', $signingKey);
        $this->assertFalse($isValid, 'The given payment complete response was valid, but should be invalid');
    }

    public function testThatIsValidReturnsTrueForUnderscoreInStatus() {
        $signingKey = new SigningKey('secret');
        $paymentCompletedResponse = PaymentCompletedResponse::createInstance('1', 'IN_PROGRESS', '1a551027bc3cc041a56b9efa252640c76b2e5815f816dd123fa1b32b4683729e904b5fa711870b956f1d9b16c714168d129068a48f875c2f91185d6c18eccf61', $signingKey);
        $this->assertNotFalse($paymentCompletedResponse);
        $this->assertEquals('1', $paymentCompletedResponse->getOrderID());
        $this->assertEquals('IN_PROGRESS', $paymentCompletedResponse->getStatus());
    }

    public function testIsValidReturnsTrueForNonIntegerIds()
    {
        $signingKey = new SigningKey('secret');
        $paymentCompletedResponse = PaymentCompletedResponse::createInstance('866a13038dd88f851fa3556a3b7d2da515018a95', 'COMPLETED', 'f29bc3142089ba67f3ff62a9b4b94fd2c923f50adbd752430ae480f70727863de750aa05d2dbae1bd0adb0c380135cbac34062b121cb051fbf9193a6a1c016fe', $signingKey);
        $this->assertNotFalse($paymentCompletedResponse);
        $this->assertEquals('866a13038dd88f851fa3556a3b7d2da515018a95', $paymentCompletedResponse->getOrderID());
        $this->assertEquals('COMPLETED', $paymentCompletedResponse->getStatus());
    }
}
