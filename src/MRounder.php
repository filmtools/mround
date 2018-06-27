<?php
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
     * @var numeric
     */
    public $multiple;


    /**
     * @param numeric $multiple
     */
    public function __construct( $multiple = 1 )
    {
        if (is_numeric($multiple))
            $this->multiple = $multiple;
        else
            throw new MRoundInvalidArgumentException("Parameter must be numeric.");
    }


    /**
     * Accepts a number or array with numbers.
     * @param numeric[] $number
     */
    public function __invoke( $number )
    {
        if (is_numeric($number)):
            return ($this->multiple <> 0)
            ? mround( $number, $this->multiple)
            : 0;
        elseif (is_array( $number)):
            return array_map($this, $number);
        endif;

        throw new MRoundInvalidArgumentException("Number must be numeric or array of numbers.");
    }
}
