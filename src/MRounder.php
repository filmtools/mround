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
     * Default rounding behaviour
     * @var string
     */
    const FLOOR="floor";

    /**
     * Turn on CEILING functionality
     * @var string
     */
    const CEIL="ceil";

    /**
     * Turn on FLOOR functionality
     * @var string
     */
    const ROUND="round";

    /**
     * @var numeric
     */
    public $multiple;

    /**
     *
     * @var string
     */
    public $mode;


    /**
     * @param numeric $multiple
     */
    public function __construct( $multiple = 1, $mode = null )
    {
        if (is_numeric($multiple))
            $this->multiple = $multiple;
        else
            throw new MRoundInvalidArgumentException("Parameter 'multiple' must be numeric.");


        if (in_array($mode, [ null, static::FLOOR, static::CEIL, static::ROUND ]))
            $this->mode = $mode ?: static::ROUND;
        else
            throw new MRoundInvalidArgumentException("Parameter 'mode' must be one of 'round', floor', or 'ceil'.");
    }


    /**
     * Accepts a number or array with numbers.
     * @param numeric[] $number
     */
    public function __invoke( $number )
    {
        if (is_numeric($number)):
            if ($this->multiple == 0)
                return 0;

            switch ($this->mode):
                case static::ROUND:
                    return mround( $number, $this->multiple );

                case static::FLOOR:
                    return mfloor( $number, $this->multiple );

                case static::CEIL:
                    return mceil( $number, $this->multiple );

                default:
                    throw new MRoundUnexpectedValueException("Unexpected round mode value");

            endswitch;

        elseif (is_array( $number)):
            return array_map($this, $number);
        endif;

        throw new MRoundInvalidArgumentException("Number must be numeric or array of numbers.");
    }
}
