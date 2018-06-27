# FilmTools · mround

**PHP implementation for Excel's mround function: Returns a number rounded to the nearest multiple of another number.**

[![Build Status](https://travis-ci.org/filmtools/mround.svg?branch=master)](https://travis-ci.org/filmtools/mround)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/filmtools/mround/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/filmtools/mround/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/filmtools/mround/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/filmtools/mround/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/filmtools/mround/badges/build.png?b=master)](https://scrutinizer-ci.com/g/filmtools/mround/build-status/master)


## Installation

```bash
$ composer require filmtools/mround
```

## Examples

This package offers mround in two flavours, function **mround** and callable **MRounder** class. Both return a number rounded to the nearest multiple of another number. See the official *mround* function documentations: [Excel](https://support.office.com/en-us/article/mround-function-c299c3b0-15a5-426d-aa4b-d2d5b3baf427) · [LibreOffice](https://help.libreoffice.org/Calc/Mathematical_Functions#MROUND) · [OpenOffice](https://wiki.openoffice.org/wiki/Documentation/How_Tos/Calc:_MROUND_function)

### Function mround

The function is namespaced, so you will have to mention it in your `use` statements.

```php
<?php
use function FilmTools\MRounder\mround;

// Try some numbers
echo mround(   12,  10);
echo mround(  2.4, 0.5);
echo mround( 11.2, 1/3);
echo mround( 11.1, 1/3);

// Output:
10
2.5
11.333333333333
11
```

### Callable MRounder

```php
<?php
use FilmTools\MRounder\MRounder;

// Instantiate with the desired multiple
$mrounder = new MRounder( 0.5 );
echo $mrounder( 2.4 );
// 2.5

// You will find this interesting:
echo mround( 99, 0);    
// 0    
```

**Arrays are welcome!**

```php
// Build an array with equal keys and values:
$steps = range(0, 1, 0.1);
$numbers = array_combine($steps, $steps);

// Now let's round to multiples
// of one-sixth fraction:
$mround = new MRounder( 1/6 );
$sixths = array_map($mround, $numbers);
print_r($sixths);

// Output:
Array
(
    [0] => 0
    [0.1] => 0.16666666666667
    [0.2] => 0.16666666666667
    [0.3] => 0.33333333333333
    [0.4] => 0.33333333333333
    [0.5] => 0.5 # funny, but equals 2/6 actually.
    [0.6] => 0.66666666666667
    [0.7] => 0.66666666666667
    [0.8] => 0.83333333333333
    [0.9] => 0.83333333333333
    [1] => 1
)
```



## Exceptions

When passed not-numeric numbers, both *MRounder* and *mround* will throw a **MRoundInvalidArgumentException** which extends PHP's *\InvalidArgumentException* and implements the **MRoundExceptionInterface.**

```php
<?php
use FilmTools\MRounder\MRounder;
use FilmTools\MRounder\MRoundInvalidArgumentException;
use FilmTools\MRounder\MRoundExceptionInterface;

try {
  	$mround = new MRounder( "foobar" );  
    // accordingly
    echo mround( 22, "string");
    echo mround( "foo", 4);        
}
catch (MRoundExceptionInterface $e) {
    echo get_class( $e );
	echo $e->getMessage();
    // MRoundInvalidArgumentException
    // Parameter must be numeric.
}
```



## Development and Unit testing

```bash
$ git clone https://github.com/filmtools/mround.git
$ composer install
$ vendor/bin/phpunit
```

