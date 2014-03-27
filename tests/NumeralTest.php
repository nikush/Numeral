<?php

namespace Nikush\Numeral;

class NumeralTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Nikush\Numeral\Numeral
     */
    protected $numeral;

    /**
     * @var \Nikush\Numeral\Locales\Locale
     */
    protected $mock;

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->getMock('\Nikush\Numeral\Locales\Locale');
        $this->numeral = new Numeral();
        $this->numeral->setLocale($this->mock);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->numeral, $this->mock);
    }

    /**
     * @covers \Nikush\Numeral\Numeral::__construct
     */
    public function testConstructor()
    {
        setlocale(LC_ALL, 'en_GB.UTF-8');   // set machine locale
        // nothing specified, detect machine locale
        $temp = new Numeral();
        $this->assertInstanceOf('\\Nikush\\Numeral\\Locales\\En_GB', $temp->getLocale());

        // specified en_GB
        $temp = new Numeral('en_GB');
        $this->assertInstanceOf('\\Nikush\\Numeral\\Locales\\En_GB', $temp->getLocale());

        // unrecognised locale, default to en_US
        $temp = new Numeral('crap');
        $this->assertInstanceOf('\\Nikush\\Numeral\\Locales\\En_US', $temp->getLocale());

        unset($temp);
    }

    /**
     * @covers \Nikush\Numeral\Numeral::cardinal
     */
    public function testNegativeCardinal()
    {
        $this->mock->expects($this->once())
            ->method('getCardinal')
            ->with(1)
            ->will($this->returnValue('One'));
        $this->mock->expects($this->once())
            ->method('getNegativeWord')
            ->will($this->returnValue('Negative'));
        $this->assertEquals($this->numeral->cardinal(-1), 'Negative One');
    }

    /**
     * @covers \Nikush\Numeral\Numeral::cardinal
     */
    public function testCardinalFloat()
    {
        $this->mock->expects($this->any())
            ->method('getCardinal')
            ->will($this->returnValue('One'));
        $this->mock->expects($this->once())
            ->method('getDecimalWord')
            ->will($this->returnValue('Point'));
        $this->assertEquals($this->numeral->cardinal(1.11), 'One Point One One');
    }

    /**
     * @covers \Nikush\Numeral\Numeral::cardinal
     */
    public function testCardinalFloatZeroDecimal()
    {
        $this->mock->expects($this->any())
            ->method('getCardinal')
            ->will($this->returnValueMap(array(
                array(0, 'Zero'),
                array(1, 'One'),
            )));
        $this->mock->expects($this->once())
            ->method('getDecimalWord')
            ->will($this->returnValue('Point'));
        $this->assertEquals($this->numeral->cardinal(1.0), 'One Point Zero');
    }

    /**
     * @covers \Nikush\Numeral\Numeral::ordinal
     */
    public function testOrdinal()
    {
        $this->mock->expects($this->once())
            ->method('getOrdinal')
            ->with(1)
            ->will($this->returnValue('First'));
        $this->assertEquals($this->numeral->ordinal(1), 'First');
    }

    /**
     * @covers \Nikush\Numeral\Numeral::ordinal
     */
    public function testOrdinalConvertsNegatives()
    {
        $this->mock->expects($this->once())
            ->method('getOrdinal')
            ->with(1)
            ->will($this->returnValue('First'));
        $this->assertEquals($this->numeral->ordinal(-1), 'First');
    }

    /**
     * @covers \Nikush\Numeral\Numeral::ordinal
     * @expectedException OutOfRangeException
     * @expectedExceptionMessage Provided number must be a positive interger greater than 0
     */
    public function testOrdinalThrowExceptionWhenGivenZero()
    {
        $this->numeral->ordinal(0);
    }
}
