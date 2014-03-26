<?php

namespace Nikush;

/**
 * Class for acquiring numeral forms of numbers
 *
 * @author Nikush Patel
 * @link   http://en.wikipedia.org/wiki/English_numerals
 */
class Numeral
{
    /**
     * @var array Names of numbers 0-9
     */
    protected $cardinalUnits = array(
        'Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight',
        'Nine'
    );

    /**
     * @var array Names of numbers that are multiples of tens
     */
    protected $cardinalTens = array(
        'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy',
        'Eighty', 'Ninety'
    );

    /**
     * @var array Names of numbers 10-19 that don't fit into the pattern
     */
    protected $cardinalTen2Twenty = array(
        'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen',
        'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
    );

    /**
     * @var array Names of big numbers going up in thousands
     */
    protected $cardinalThousands = array(
        'Thousand', 'Million', 'Billion', 'Trillion', 'Quadrillion',
        'Quintillion'
    );

    /**
     * @var array Names of ordinal units
     */
    protected $ordinalUnits = array(
        'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh',
        'Eighth', 'Ninth'
    );

    /**
     * Get the cardinal form of any number
     *
     * @param  number $num
     * @return string
     */
    public function cardinal($num)
    {
        $decimals = ''; // cardinal decimal numbers
        $sign = $num < 0 ? 'Minus ' : '';
        $num = abs($num);   // normalize to an absolute number

        if (is_float($num)) {
            $decimals = ' Point';

            // process the float as a string and cut off the decimals to parse
            // them
            // gotcha: if the decimal is 0, when converted to a string php will
            // print the number as an int: strval(2.0) // 2
            if (!strpos($num, '.')) {
                // if no decimals point was found, the decimal is 0
                $decimals .= ' ' . $this->cardinalUnits[0];
            } else {
                list($before_dot, $after_dot) = explode('.', $num);
                foreach (str_split($after_dot) as $char) {
                    $decimals .= ' ' . $this->cardinalUnits[$char];
                }
            }
            // normalize to an int for the rest of the parsing
            $num = (int) $num;
        }

        return $sign . $this->cardinalInt($num) . $decimals;
    }

    /**
     * Get the cardinal of an absolute integer
     *
     * @param  int    $num
     * @return string
     */
    protected function cardinalInt($num)
    {
        if ($num < 10) {
            return $this->cardinalUnits[$num];
        }
        if ($num < 20) {
            return $this->cardinalTen2Twenty[$num - 10];
        }
        if ($num < 100) {
            $tens = (int) floor($num / 10);   // multiple of tens
            $units = $num % 10;         // single after the ten

            $str = $this->cardinalTens[$tens - 1];
            if ($units != 0) {
                // tens are hyphenated, eg. Twenty-One
                $str .= '-' . $this->cardinalUnits[$units];
            }
            return $str;
        }
        if ($num < 1000) {
            $hundred = (int) floor($num / 100); // multiple of hundreds
            $tens = $num % 100;                 // tens
            $str = $this->cardinalUnits[$hundred];
            $str .= ' Hundred';
            if ($tens != 0) {
                $str .= ' and ';
                $str .= $this->cardinalint($tens);
            }
            return $str;
        }

        // loop through big number names highest to lowest
        for ($i = count($this->cardinalThousands) - 1; $i >= 0; $i--) {
            // value of the current big number, eg. thousand = 1000
            $val = pow(1000, $i + 1);
            if ($num < $val) {
                continue;   // skip if it's too big
            }

            $name = $this->cardinalThousands[$i];   // name of current number
            // how many of the current number? 1 thousand? 2 thousand? etc.
            $multiple = (int) floor($num / $val);

            // get the cardinal for $multiple
            $str = $this->cardinalint($multiple);
            $str .= " $name";

            // the rest of the number after the multiple
            $rest = $num % $val;
            if ($rest != 0) {
                if ($rest < 100) {
                    $str .= ' and';
                }
                $str .= ' ' . $this->cardinalInt($rest);
            }
            return $str;
        }
    }

    /**
     * Get the ordinal form of any number
     *
     * @param  int    $num
     * @return string
     */
    public function ordinal($num)
    {
        $num = (int) abs($num);  // ordinals only work for unsigned ints!
        if ($num == 0) {
            throw new \OutOfRangeException("Provided number must be a positive interger greater than 0");
        }

        if ($num < 10) {
            return $this->ordinalUnits[$num - 1];
        }
        if ($num < 20) {
            if ($num == 12) {
                return 'Twelfth';
            }
            return $this->cardinalInt($num).'th';
        }
        if ($num < 100) {
            $tens = (int) floor($num / 10);
            $units = $num % 10;

            if ($units == 0) {
                $str = $this->cardinalInt($tens * 10);  // get the cardinal
                return str_replace('y', 'ieth', $str);  // convert to ordinal
            }

            $str = $this->cardinalInt($tens * 10);
            $str .= '-' . $this->ordinalUnits[$units - 1];
            return $str;
        }
        if ($num < 1000) {
            $multiple = (int) floor($num / 100);
            $tens = $num % 100;

            $str = $this->cardinal($multiple * 100);

            if ($tens == 0) {
                return $str .= 'th';
            }

            return $str . ' and ' . $this->ordinal($tens);
        }

        // loop through big number names highest to lowest
        for ($i = count($this->cardinalThousands) - 1; $i >= 0; $i--) {
            $val = pow(1000, $i + 1);
            if ($num < $val) {
                continue;   // skip if it's too big
            }

            // how many of the current number? 1 thousand? 2 thousand? etc.
            $multiple = (int) floor($num / $val);

            // the rest of the number after the multiple
            $rest = $num % $val;

            $str = $this->cardinal($multiple * $val);

            if ($rest == 0) {
                return $str .= 'th';
            }
            if ($rest < 100) {
                $str .= ' and';
            }

            return $str . ' ' . $this->ordinal($rest);
        }
    }
}
