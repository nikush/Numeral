<?php

namespace Nikush\Numeral;

/**
 * Class for acquiring numeral forms of numbers
 *
 * @author Nikush Patel
 */
class Numeral
{
    /**
     * @var \Nikush\Numeral\Locales\Locale
     */
    protected $locale;

    /**
     * Constructor
     *
     * If the locale is not specified, it will attempt to detect the locale set
     * on the machine.  If the specified or detected locale is unrecognised, it
     * will default to 'en_US'.
     *
     * @param string $locale The locale to use
     */
    public function __construct($locale = null)
    {
        $locales = array(
            'en_US' => 'En_US',
            'en_GB' => 'En_GB',
        );

        // detect the user's locale
        if (is_null($locale)) {
            $parts = explode('.', setlocale(LC_CTYPE, 0));
            $locale = $parts[0];
        }

        // default to en_US if specified locale is not registered
        if (!isset($locales[$locale])) {
            $locale = 'en_US';
        }

        $l = '\\Nikush\\Numeral\\Locales\\'.$locales[$locale];
        $l = new $l();          // instantiate it
        $this->setLocale($l);
    }

    /**
     * @param \Nikush\Numeral\Locales\Locale $locale
     * @codeCoverageIgnore
     */
    public function setLocale(\Nikush\Numeral\Locales\Locale $locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return \Nikush\Numeral\Locales\Locale
     * @codeCoverageIgnore
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get the cardinal form of any number
     *
     * @param  number $num
     * @return string
     */
    public function cardinal($num)
    {
        $decimals = '';     // cardinal decimal numbers
        $sign = $num < 0 ? $this->locale->getNegativeWord().' ' : '';
        $num = abs($num);   // normalize to an absolute number

        if (is_float($num)) {
            $decimals = ' '.$this->locale->getDecimalWord();

            // process the float as a string and cut off the decimals to parse
            // them
            // gotcha: if the decimal is 0, when converted to a string php will
            // print the number as an int: strval(2.0) // 2
            if (!strpos($num, '.')) {
                // if no decimals point was found, the decimal is 0
                $decimals .= ' ' . $this->locale->getCardinal(0);
            } else {
                list($before_dot, $after_dot) = explode('.', $num);
                foreach (str_split($after_dot) as $digit) {
                    $decimals .= ' ' . $this->locale->getCardinal($digit);
                }
            }
            // normalize to an int for the rest of the parsing
            $num = (int) $num;
        }

        return $sign . $this->locale->getCardinal($num) . $decimals;
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

        return $this->locale->getOrdinal($num);
    }
}
