<?php

namespace Nikush\Numeral\Locales;

/**
 * @author Nikush Patel
 * @link   http://en.wikipedia.org/wiki/English_numerals
 */
class En_US extends Locale
{
    /**
     * @var array Names of numbers 0-9
     */
    protected $cardinalUnits = array(
        'Zero',
        'One',
        'Two',
        'Three',
        'Four',
        'Five',
        'Six',
        'Seven',
        'Eight',
        'Nine'
    );

    /**
     * @var array Names of numbers that are multiples of tens
     */
    protected $cardinalTens = array(
        'Ten',
        'Twenty',
        'Thirty',
        'Forty',
        'Fifty',
        'Sixty',
        'Seventy',
        'Eighty',
        'Ninety'
    );

    /**
     * @var array Names of teen numbers 10-19 that don't fit into the pattern
     */
    protected $cardinalTeens = array(
        'Ten',
        'Eleven',
        'Twelve',
        'Thirteen',
        'Fourteen',
        'Fifteen',
        'Sixteen',
        'Seventeen',
        'Eighteen',
        'Nineteen'
    );

    /**
     * @var array Names of big numbers going up in thousands
     */
    protected $cardinalThousands = array(
        'Thousand',
        'Million',
        'Billion',
        'Trillion',
        'Quadrillion',
        'Quintillion'
    );

    /**
     * @var array Names of ordinal units
     */
    protected $ordinalUnits = array(
        'First',
        'Second',
        'Third',
        'Fourth',
        'Fifth',
        'Sixth',
        'Seventh',
        'Eighth',
        'Ninth'
    );

    /**
     * {@inheritDoc}
     * @codeCoverageIgnore
     */
    public function getNegativeWord()
    {
        return 'Negative';
    }

    /**
     * {@inheritDoc}
     * @codeCoverageIgnore
     */
    public function getDecimalWord()
    {
        return 'Point';
    }

    /**
     * {@inheritDoc}
     */
    public function getCardinalUnits($num)
    {
        return $this->cardinalUnits[$num];
    }

    /**
     * {@inheritDoc}
     */
    public function getCardinalTeens($num)
    {
        return $this->cardinalTeens[$num];
    }

    /**
     * {@inheritDoc}
     */
    public function getCardinalTens($multiple, $units)
    {
        $str = $this->cardinalTens[$multiple - 1];
        if ($units != 0) {
            // tens are hyphenated, eg. Twenty-One
            $str .= '-' . $this->getCardinalUnits($units);
        }
        return $str;
    }

    /**
     * {@inheritDoc}
     */
    public function getCardinalHundreds($multiple, $tens)
    {
        $str = $this->getCardinalUnits($multiple);
        $str .= ' Hundred';
        if ($tens != 0) {
            $str .= ' ' . $this->getCardinal($tens);
        }
        return $str;
    }

    /**
     * {@inheritDoc}
     */
    public function getCardinalThousands($multiple, $i)
    {
        // name of current number
        $name = $this->cardinalThousands[$i];
        // get the cardinal for $multiple
        $str = $this->getCardinal($multiple);
        return $str .= " $name";
    }

    /**
     * {@inheritDoc}
     */
    public function getCardinalThousandsRest($num)
    {
        return ' ' . $this->getCardinal($num);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdinalUnits($num)
    {
        return $this->ordinalUnits[$num - 1];
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdinalTeens($num)
    {
        if ($num == 12) {
            return 'Twelfth';
        }
        return $this->getCardinal($num).'th';
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdinalTens($multiple, $units)
    {
        if ($units == 0) {
            $str = $this->getCardinal($multiple * 10);
            return str_replace('y', 'ieth', $str);
        }

        $str = $this->getCardinal($multiple * 10);
        $str .= '-' . $this->ordinalUnits[$units - 1];
        return $str;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdinalHundreds($multiple, $tens)
    {
        $str = $this->getCardinal($multiple * 100);
        if ($tens == 0) {
            return $str .= 'th';
        }
        return $str . ' ' . $this->getOrdinal($tens);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdinalThousands($multiple, $val, $rest)
    {
        $str = $this->getCardinal($multiple * $val);
        if ($rest == 0) {
            $str .= 'th';
        }
        return $str;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdinalThousandsRest($num)
    {
        return ' ' . $this->getOrdinal($num);
    }
}
