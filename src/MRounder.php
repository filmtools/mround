<?php

/**
 * This file is part of filmtools/mround
 *
 * Rounds a number to the nearest multiple of another number (mround, ceiling, floor)
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace FilmTools\MRounder;

/**
 * Callable: Returns a given number rounded to the desired multiple.
 *
 * PHP implementation by Nasser Hekmati on StackOverflow
 * @see https://stackoverflow.com/a/48643210/3143771
 * @see https://support.office.com/en-us/article/mround-function-c299c3b0-15a5-426d-aa4b-d2d5b3baf427
 */
class MRounder
{
    /**
     * Default rounding behaviour
     * @var string
     */
    public const FLOOR = "floor";

    /**
     * Turn on CEILING functionality
     * @var string
     */
    public const CEIL = "ceil";

    /**
     * Turn on FLOOR functionality
     * @var string
     */
    public const ROUND = "round";

    /**
     * @var numeric
     */
    public $multiple;

    /**
     *
     * @var string
     */
    public $mode;


    public function __construct(mixed $multiple = 1, mixed $mode = null)
    {
        if (is_numeric($multiple)) {
            $this->multiple = $multiple;
        } else {
            throw new MRoundInvalidArgumentException("Parameter 'multiple' must be numeric.");
        }


        if ($mode === null) {
            $this->mode = static::ROUND;
        } elseif (in_array($mode, [static::FLOOR, static::CEIL, static::ROUND], true)) {
            $this->mode = $mode;
        } else {
            throw new MRoundInvalidArgumentException("Parameter 'mode' must be one of 'round', floor', or 'ceil'.");
        }
    }


    /**
     * Accepts a number or array with numbers.
     */
    public function __invoke(mixed $number): mixed
    {
        if (is_numeric($number)):
            if ($this->multiple == 0) {
                return 0;
            }

            return match ($this->mode) {
                static::ROUND => mround($number, $this->multiple),
                static::FLOOR => mfloor($number, $this->multiple),
                static::CEIL => mceil($number, $this->multiple),
                default => throw new MRoundUnexpectedValueException("Unexpected round mode value"),
            };
        elseif (is_array($number)):
            return array_map(fn($item) => $this($item), $number);
        endif;

        throw new MRoundInvalidArgumentException("Number must be numeric or array of numbers.");
    }
}
