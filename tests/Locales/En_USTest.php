<?php

namespace Nikush\Numeral\Locales;

class En_USTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Nikush\Numeral\Locales\En_US
     */
    protected $locale;

    public function setUp()
    {
        parent::setUp();
        $this->locale = new En_US();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->locale);
    }

    /**
     * @coveras \Nikush\Numeral\Locales\En_US::getCardinal
     * @dataProvider cardinalProvider
     */
    public function testCardinals($num, $string)
    {
        $this->assertEquals($this->locale->getCardinal($num), $string);
    }

    /**
     * @coveras \Nikush\Numeral\Locales\En_US::getOrdinal
     * @dataProvider ordinalProvider
     */
    public function testOrdinals($num, $string)
    {
        $this->assertEquals($this->locale->getOrdinal($num), $string);
    }

    public function cardinalProvider()
    {
        return [
            [0, 'Zero'],
            [1, 'One'],
            [11, 'Eleven'],
            [69, 'Sixty-Nine'],
            [101, 'One Hundred One'],
            [999, 'Nine Hundred Ninety-Nine'],
            [1001, 'One Thousand One'],
            [1234, 'One Thousand Two Hundred Thirty-Four'],
            [12345, 'Twelve Thousand Three Hundred Forty-Five'],
            [101000, 'One Hundred One Thousand'],
            [123456, 'One Hundred Twenty-Three Thousand Four Hundred Fifty-Six'],
            [1000001, 'One Million One'],
            [1234567, 'One Million Two Hundred Thirty-Four Thousand Five Hundred Sixty-Seven'],
            [20000000, 'Twenty Million'],
            [300000000, 'Three Hundred Million'],
            [4000000000, 'Four Billion'],
        ];
    }

    public function ordinalProvider()
    {
        return [
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
            [101, 'One Hundred First'],
            [110, 'One Hundred Tenth'],
            [111, 'One Hundred Eleventh'],
            [120, 'One Hundred Twentieth'],
            [121, 'One Hundred Twenty-First'],
            [1000, 'One Thousandth'],
            [1001, 'One Thousand First'],
            [1010, 'One Thousand Tenth'],
            [1100, 'One Thousand One Hundredth'],
            [10000, 'Ten Thousandth'],
            [100000, 'One Hundred Thousandth'],
            [1000000, 'One Millionth'],
            [1000001, 'One Million First'],
        ];
    }
}
