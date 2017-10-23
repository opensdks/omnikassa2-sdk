<?php namespace nl\rabobank\gict\payments_savings\omnikassa_sdk\model;


class MoneyTest extends \PHPUnit_Framework_TestCase
{

    public function testFromDecimal_CorrectRounding()
    {
        $noRoundingNeeded = Money::fromDecimal('EUR', 9.99);
        $this->assertEquals(999, $noRoundingNeeded->getAmount(), 'Amount is incorrect for scenario: no rounding needed');

        $roundCeilingNeeded = Money::fromDecimal('EUR', 9.999);
        $this->assertEquals(1000, $roundCeilingNeeded->getAmount(), 'Amount is incorrect for scenario: round ceiling required');

        $roundFloorNeeded = Money::fromDecimal('EUR', 9.991);
        $this->assertEquals(999, $roundFloorNeeded->getAmount(), 'Amount is incorrect for scenario: round floor required');

        $edgeCase = Money::fromDecimal('EUR', 9.995);
        $this->assertEquals(1000, $edgeCase->getAmount(), 'Amount is incorrect for scenario: edge case (0.5)');
    }
}
