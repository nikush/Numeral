<?php

namespace Nikush\Numeral\Locales;

/**
 * @author Nikush Patel
 */
class En_GB extends En_US
{
    /**
     * {@inheritDoc}
     * @codeCoverageIgnore
     */
    public function getNegativeWord()
    {
        return 'Minus';
    }

    /**
     * {@inheritDoc}
     */
    public function getCardinalHundreds($multiple, $tens)
    {
        $str = $this->getCardinalUnits($multiple);
        $str .= ' Hundred';
        if ($tens != 0) {
            $str .= ' and ';
            $str .= $this->getCardinal($tens);
        }
        return $str;
    }

    /**
     * {@inheritDoc}
     */
    public function getCardinalThousandsRest($num)
    {
        $str = ' ';
        if ($num < 100) {
            $str .= 'and ';
        }
        $str .= $this->getCardinal($num);
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
        return $str . ' and ' . $this->getOrdinal($tens);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdinalThousands($multiple, $val, $rest)
    {
        $str = $this->getCardinal($multiple * $val);
        if ($rest == 0) {
            $str .= 'th';
        } elseif ($rest < 100) {
            $str .= ' and';
        }
        return $str;
    }
}
