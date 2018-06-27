<?php
namespace FilmTools\MRounder;


/**
 * Returns the given number rounded to the given multiple.
 *
 * PHP implementation by Nasser Hekmati on StackOverflow
 * @see https://stackoverflow.com/a/48643210/3143771
 * @see https://support.office.com/en-us/article/mround-function-c299c3b0-15a5-426d-aa4b-d2d5b3baf427
 *
 * @param int|float $number
 * @param int|float $multiple
 */
function mround( $number, $multiple)
{
    if (!is_numeric($number))
        throw new MRoundInvalidArgumentException("First parameter must be numeric.");

    if (!is_numeric($multiple))
        throw new MRoundInvalidArgumentException("Second parameter 'multiple' must be numeric.");
    elseif ( $multiple == 0)
        return 0;

    return round( $number/$multiple, 0 ) * $multiple;

}

// This snippet is not required any longer since we're in namespace here.
# if (!function_exists("mround")):
# endif;

