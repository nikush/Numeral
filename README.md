Numeral
=======
This library provides an easy way to convert numbers to words.  It supports
the cardinal (one, two, three, etc.) and ordinal (first, second, third, etc.)
forms.

It has been designed to accept any number (integers and floats, both positive
and negative) and is able to work up to PHP's highest numeric value,
`PHP_INT_MAX`, a little over 9 quintillion!

Installation
------------
Install using [Composer](https://getcomposer.org):

```php
{
    "require": {
        "nikush/numeral": "dev-master"
    }
}
```

Usage
-----
There are just two methods exposing the Numeral API: `Numeral::cardinal()` and
`Numeral::ordinal()`.

```php
<?php
use Nikush\Numeral;

$n = new Numeral();

echo $n->cardinal(1); // 'One'

echo $n->ordinal(1);  // 'First'
```

A more practical example:
```php
<?php
use Nikush\Numeral;
$n = new Numeral();

printf('%s %s %s %s',
  date('l'),                // day of the week
  $n->ordinal(date('d')),   // day of the month
  date('F'),                // month name
  $n->cardinal(date('Y'))   // year
);
// Wednesday Twenty-Sixth March Two Thousand and Fourteen
```
