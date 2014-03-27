<?php

namespace Nikush\Numeral\Locales;

/**
 * Base class for all locales with basic logic for deconstructing and
 * processing numbers
 *
 * @author Nikush Patel
 */
abstract class Locale
{
    /**
     * @return string
     */
    abstract public function getNegativeWord();

    /**
     * @return string
     */
    abstract public function getDecimalWord();

    /**
     * Get the cardinal form of any integer
     *
     * @param  int    $num
     * @return string
     */
    public function getCardinal($num)
    {
        if ($num < 10) {
            return $this->getCardinalUnits($num);
        }
        if ($num < 20) {
            return $this->getCardinalTeens($num - 10);
        }
        if ($num < 100) {
            $multiple = (int) floor($num / 10);
            $units = $num % 10;
            return $this->getCardinalTens($multiple, $units);
        }
        if ($num < 1000) {
            $multiple = (int) floor($num / 100);
            $tens = $num % 100;
            return $this->getCardinalHundreds($multiple, $tens);
        }

        // formula to calculate which exponent this number is
        // fits in with the values of the $cardinalThousands array
        // 0=thousand, 1=million, etc.
        $i = floor((strlen($num) - 4) / 3);
        $val = pow(1000, $i + 1);
        $multiple = (int) floor($num / $val);

        $str = $this->getCardinalThousands($multiple, $i);

        // the rest of the numbers after the multiple
        $rest = $num % $val;
        if ($rest != 0) {
            $str .= $this->getCardinalThousandsRest($rest);
        }
        return $str;
    }

    /**
     * Get the cardinal form of a single digit: 0-9
     *
     * @param  int    $num
     * @return string
     */
    abstract public function getCardinalUnits($num);

    /**
     * Get the cardinal form of teen numbers: 11-19
     *
     * @param  int    $num
     * @return string
     */
    abstract public function getCardinalTeens($num);

    /**
     * Get the cardinal form of 2 figure numbers: 20-99
     *
     * @param  int    $multiple Multiple of tens
     * @param  int    $units    Remaining digits
     * @return string
     */
    abstract public function getCardinalTens($multiple, $units);

    /**
     * Get the cardinal form of 3 figure numbers: 100-999
     *
     * @param  int    $multiple Multiple of hundreds
     * @param  int    $tens     Remaining digits
     * @return string
     */
    abstract public function getCardinalHundreds($multiple, $tens);

    /**
     * Get the cardinal form of numbers 1000 and up
     *
     * $i: 0=thousand, 1=million, etc.
     *
     * @param  int    $multiple Multiple of thousands
     * @param  int    $i        Index of number in $cardinalThousands array
     * @return string
     */
    abstract public function getCardinalThousands($multiple, $i);

    /**
     * Called between each thousands number to allow for additional logic to be
     * applied
     *
     * When processing the number 1001, after the 1000 part has been processed,
     * this method will receive the remaining value 1.  Normally this method
     * would prefix a space and run that value through the ::cardinal() method.
     * In the case of the en_GB locale, this allows for the strings to be
     * prefixed with 'and' resulting in 'One Thousand and One'.
     *
     * @param  int    $num
     * @return string
     */
    abstract public function getCardinalThousandsRest($num);

    /**
     * Get the ordinal form of any integer
     *
     * @param  int    $num
     * @return string
     */
    public function getOrdinal($num)
    {
        if ($num < 10) {
            return $this->getOrdinalUnits($num);
        }
        if ($num < 20) {
            return $this->getOrdinalTeens($num);
        }
        if ($num < 100) {
            $multiple = (int) floor($num / 10);
            $units = $num % 10;
            return $this->getOrdinalTens($multiple, $units);
        }
        if ($num < 1000) {
            $multiple = (int) floor($num / 100);
            $tens = $num % 100;
            return $this->getOrdinalHundreds($multiple, $tens);
        }

        $i = floor((strlen($num) - 4) / 3);
        $val = pow(1000, $i + 1);
        $multiple = (int) floor($num / $val);
        $rest = $num % $val;

        $str = $this->getOrdinalThousands($multiple, $val, $rest);

        if ($rest == 0) {
            return $str;
        }

        $str .= $this->getOrdinalThousandsRest($rest);
        return $str;
    }

    /**
     * Get the ordinal form of a single digit: 0-9
     *
     * @param  int    $num
     * @return string
     */
    abstract public function getOrdinalUnits($num);

    /**
     * Get the ordinal form of teen numbers: 11-19
     *
     * @param  int    $num
     * @return string
     */
    abstract public function getOrdinalTeens($num);

    /**
     * Get the ordinal form of 2 figure numbers: 20-99
     *
     * @param  int    $multiple Multiple of tens
     * @param  int    $units    Remaining digits
     * @return string
     */
    abstract public function getOrdinalTens($multiple, $units);

    /**
     * Get the ordinal form of 3 figure numbers: 100-999
     *
     * @param  int    $multiple Multiple of hundreds
     * @param  int    $tens     Remaining digits
     * @return string
     */
    abstract public function getOrdinalHundreds($multiple, $tens);

    /**
     * Get the ordinal form of numbers 1000 and up
     *
     * @param  int    $multiple Multiple of thousands
     * @param  int    $val      The value of the exponent
     * @param  int    $rest     All of the numbers below the exponent
     * @return string
     */
    abstract public function getOrdinalThousands($multiple, $val, $rest);

    /**
     * Called between each thousands number to allow for additional logic to be
     * applied
     *
     * @param  int    $num
     * @return string
     */
    abstract public function getOrdinalThousandsRest($num);
}
