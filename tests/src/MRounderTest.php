<?php
namespace tests;

use FilmTools\MRounder\MRounder;
use FilmTools\MRounder\MRoundInvalidArgumentException;
use FilmTools\MRounder\MRoundUnexpectedValueException;
use FilmTools\MRounder\MRoundExceptionInterface;

class MRounderTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider provideVariousParameters
     */
    public function testSimple( $input, $multiple, $mode, $expected)
    {
        $mround = new MRounder( $multiple, $mode );

        $result = $mround( $input );
        $this->assertEquals( $result, $expected);
    }


    /**
     * @dataProvider provideInvalidArgumentsForCtor
     */
    public function testInvalidArgumentExceptionOnCtorArgument( $may_be_invalid_number, $may_be_invalid_mode)
    {
        $this->expectException( \InvalidArgumentException::class );
        $this->expectException( MRoundInvalidArgumentException::class );
        $mround = new MRounder( $may_be_invalid_number, $may_be_invalid_mode );
    }




    public function testInvalidArgumentExceptionOnInvokation()
    {
        $mround = new MRounder( 1 );
        $this->expectException( \InvalidArgumentException::class );
        $this->expectException( MRoundInvalidArgumentException::class );
        $mround( "string" );
    }


    public function testUnexpectedValueExceptionOnInvokation()
    {
        $mround = new MRounder( 1 );
        // Change the value tgo an invalid value
        $mround->mode = "foo";
        $this->expectException( \RuntimeException::class );
        $this->expectException( \UnexpectedValueException::class );
        $this->expectException( MRoundUnexpectedValueException::class );
        $mround( 2 );
    }


    public function provideVariousParameters()
    {
        # - input number
        # - multiple
        # - rounding mode
        # - exepceted result
        return array(
            [ 100,         0,           null,               0],
            [ 100,         0,           null,               0],
            [ 0,           0,           null,               0],
            [ 11,          1,           null,              11],
            [ 11,         10,           null,              10],

            [ 51,         10,           null,              50],
            [ 51,         10,           "round",           50],
            [ 51,         10,           "round",           50],
            [ 51,         10,           "ceil",            60],
            [ 51,         10,           MRounder::CEIL,    60],


            [ 56,         10,           null,              60],
            [ 56,         10,           "round",           60],
            [ 56,         10,           MRounder::ROUND,   60],
            [ 56,         10,           "floor",           50],
            [ 56,         10,           MRounder::FLOOR,   50],

            [ 99,         10,           null,              100],
            [ "99",       10,           null,              100],

            [ 0.5,         1,           null,              1],
            [ 0.8,        0.2,          null,              0.8],
            [ 0.9,        0.2,          null,              1],
            [ 0.25,       0.125,        null,              0.25],
            [ 0.16,       1/6,          null,              1/6],

            [ [1,2],      1,            null,              [1,2] ],
            [ [0.5,0.2],  1,            null,              [1,0] ],

            [ ['foo' => 0.5, 'bar' => 0.2],
                          1,            null,      ['foo' => 1, 'bar' => 0 ] ]



        );
    }

    public function provideInvalidArgumentsForCtor()
    {
        return array(
            [ "string", null ],
            [ 99,       "foo" ],
            [ null,     null ],
        );
    }
}
