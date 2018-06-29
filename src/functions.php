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


/**
 * Returns the given number rounded up to the given multiple.
 *
 * This function corresponds to CEILING function known from Microsoft Excel in LibreOffice/OpenOffice.
 *
 * @see https://support.office.com/en-us/article/ceiling-function-0a5cd7c8-0720-4f0a-bd2c-c943e510899f
 * @see https://help.libreoffice.org/Calc/Mathematical_Functions#CEILING
 *
 * @param int|float $number
 * @param int|float $multiple
 */
function mceil( $number, $multiple)
{
    if (!is_numeric($number))
        throw new MRoundInvalidArgumentException("First parameter must be numeric.");

    if (!is_numeric($multiple))
        throw new MRoundInvalidArgumentException("Second parameter 'multiple' must be numeric.");
    elseif ( $multiple == 0)
        return 0;

    return ceil( $number/$multiple ) * $multiple;
}


/**
 * Returns the given number rounded down to the given multiple.
 *
 * This function corresponds the the FLOOR function known from Microsoft Excel in LibreOffice/OpenOffice.
 *
 * @see https://support.office.com/en-us/article/floor-function-14bb497c-24f2-4e04-b327-b0b4de5a8886
 * @see https://help.libreoffice.org/Calc/Mathematical_Functions#FLOOR
 *
 * @param int|float $number
 * @param int|float $multiple
 */
function mfloor( $number, $multiple)
{
    if (!is_numeric($number))
        throw new MRoundInvalidArgumentException("First parameter must be numeric.");

    if (!is_numeric($multiple))
        throw new MRoundInvalidArgumentException("Second parameter 'multiple' must be numeric.");
    elseif ( $multiple == 0)
        return 0;

    return floor( $number/$multiple ) * $multiple;
}
