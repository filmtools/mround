<?php
namespace tests;

use FilmTools\MRounder\MRounder;
use FilmTools\MRounder\MRoundInvalidArgumentException;
use FilmTools\MRounder\MRoundExceptionInterface;

class MRounderTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider provideVariousParameters
     */
    public function testSimple( $input, $multiple, $expected)
    {
        $mround = new MRounder( $multiple );

        $result = $mround( $input );
        $this->assertEquals( $result, $expected);
    }


    public function testInvalidArgumentExceptionOnCtorArgument()
    {
        $this->expectException( \InvalidArgumentException::class );
        $this->expectException( MRoundInvalidArgumentException::class );
        $mround = new MRounder( "some_string" );
    }


    public function testInvalidArgumentExceptionOnInvokation()
    {
        $mround = new MRounder( 1 );
        $this->expectException( \InvalidArgumentException::class );
        $this->expectException( MRoundInvalidArgumentException::class );
        $mround( "string" );
    }


    public function provideVariousParameters()
    {
        return array(
            [ 100,   0,      0],
            [ 0,     0,      0],
            [ 1,     1,      1],
            [ 11,    1,     11],
            [ 99,   10,     100],
            [ "99", 10,     100],
            [ 0.5,   1,     1],
            [ 0.8,  0.2,    0.8],
            [ 0.9,  0.2,    1],
            [ 0.25, 0.125,  0.25],
            [ 0.16, 1/6,    1/6],

            [ [1,2],      1,      [1,2] ],
            [ [0.5,0.2],  1,      [1,0] ],
            [ ['foo' => 0.5, 'bar' => 0.2],  1,     ['foo' => 1, 'bar' => 0 ] ]
        );
    }
}
