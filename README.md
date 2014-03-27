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
        "nikush/numeral": "0.2.*"
    }
}
```

### Note On Specifying Versions
The project is still in it's developmental stage, hence the major version
number remaining at 0.  The rules of [semantic versioning](http://semver.org/)
state that changes to the minor number should not break backwards
compatibility, however, during these early stages that cannot be guaranteed.
The change from 0.1.0 to 0.2.0 already introduced breaking changes.  But
changes to the patch number _will_ remain backwards compatible.  As such it is
recommended to specify version numbers where the minor number remains a
constant.  If in doubt, just use the version number specified in the example
above.

Once the project reaches a stable 1.0.0, the regular rules of semantic
versioning will come into play.

Usage
-----
There are just two methods exposing the Numeral API: `Numeral::cardinal()` and
`Numeral::ordinal()`.

```php
use Nikush\Numeral\Numeral;
$n = new Numeral();

echo $n->cardinal(1); // 'One'
echo $n->ordinal(1);  // 'First'
```

### Specifying A Locale
Currently the library only supports two locales; `en_US` and `en_GB`.

When not specified, the library will attempt to identify the locale of the
machine it's running on.  If that locale is not recognised, it will default to
`en_US`. If you want to specify a different locale, pass it in to the
constructor:

```php
// assuming your locale is set to anything other than en_GB, this will choose
// en_US
$us = new Numeral();
// specify locale directly
$gb = new Numeral('en_GB');

echo $us->cardinal(101);  // One Hundred One
echo $gb->cardinal(101);  // One Hundred and One
```

### A More Practical Example
```php
$n = new Numeral();

printf('%s %s %s %s',
    date('l'),                // day of the week
    $n->ordinal(date('d')),   // day of the month
    date('F'),                // month name
    $n->cardinal(date('Y'))   // year
);
// Wednesday Twenty-Sixth March Two Thousand Fourteen
```
