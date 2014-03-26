<?php

namespace Nikush;

class NumeralTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Nikush\Numeral
     */
    protected $numeral;

    public function setUp()
    {
        parent::setUp();
        $this->numeral = new Numeral();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->numeral);
    }

    /**
     * @dataProvider cardinalProvider
     */
    public function testCardinals($number, $cardinal)
    {
        $this->assertEquals($this->numeral->cardinal($number), $cardinal);
    }

    /**
     * @dataProvider ordinalProvider
     */
    public function testOrdinals($number, $ordinal)
    {
        $this->assertEquals($this->numeral->ordinal($number), $ordinal);
    }

    /**
     * @expectedException OutOfRangeException
     * @expectedExceptionMessage Provided number must be a positive interger greater than 0
     */
    public function testOrdinalThrowExceptionWhenGivenZero()
    {
        $this->numeral->ordinal(0);
    }

    public function cardinalProvider()
    {
        return [
            [-1, 'Minus One'],
            [0, 'Zero'],
            [1, 'One'],
            [2.0, 'Two Point Zero'],
            [2.5, 'Two Point Five'],
            [11, 'Eleven'],
            [69, 'Sixty-Nine'],
            [101, 'One Hundred and One'],
            [999, 'Nine Hundred and Ninety-Nine'],
            [1001, 'One Thousand and One'],
            [1234, 'One Thousand Two Hundred and Thirty-Four'],
            [12345, 'Twelve Thousand Three Hundred and Forty-Five'],
            [101000, 'One Hundred and One Thousand'],
            [123456, 'One Hundred and Twenty-Three Thousand Four Hundred and Fifty-Six'],
            [1000001, 'One Million and One'],
            [1234567, 'One Million Two Hundred and Thirty-Four Thousand Five Hundred and Sixty-Seven'],
            [20000000, 'Twenty Million'],
            [300000000, 'Three Hundred Million'],
            [4000000000, 'Four Billion'],
        ];
    }

    public function ordinalProvider()
    {
        return [
            [-1, 'First'],
            [1, 'First'],
            [10, 'Tenth'],
            [11, 'Eleventh'],
            [12, 'Twelfth'],
            [13, 'Thirteenth'],
            [20, 'Twentieth'],
            [21, 'Twenty-First'],
            [22, 'Twenty-Second'],
            [30, 'Thirtieth'],
            [69, 'Sixty-Ninth'],
            [100, 'One Hundredth'],
            [101, 'One Hundred and First'],
            [110, 'One Hundred and Tenth'],
            [111, 'One Hundred and Eleventh'],
            [120, 'One Hundred and Twentieth'],
            [121, 'One Hundred and Twenty-First'],
            [1000, 'One Thousandth'],
            [1001, 'One Thousand and First'],
            [1010, 'One Thousand and Tenth'],
            [1100, 'One Thousand One Hundredth'],
            [1100, 'One Thousand One Hundredth'],
            [10000, 'Ten Thousandth'],
            [100000, 'One Hundred Thousandth'],
            [1000000, 'One Millionth'],
            [1000001, 'One Million and First'],
        ];
    }
}
