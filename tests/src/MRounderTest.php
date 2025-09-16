<?php

/**
 * This file is part of filmtools/mround
 *
 * Rounds a number to the nearest multiple of another number (mround, ceiling, floor)
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace tests;

use FilmTools\MRounder\MRounder;
use FilmTools\MRounder\MRoundInvalidArgumentException;
use FilmTools\MRounder\MRoundUnexpectedValueException;
use FilmTools\MRounder\MRoundExceptionInterface;
use PHPUnit\Framework\Attributes\DataProvider;

class MRounderTest extends \PHPUnit\Framework\TestCase
{
    #[DataProvider('provideVariousParameters')]
    public function testSimple(mixed $input, float|int $multiple, ?string $mode, mixed $expected): void
    {
        $mRounder = new MRounder($multiple, $mode);

        $result = $mRounder($input);
        $this->assertEquals($result, $expected);
    }


    #[DataProvider('provideInvalidArgumentsForCtor')]
    public function testInvalidArgumentExceptionOnCtorArgument(mixed $may_be_invalid_number, mixed $may_be_invalid_mode): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectException(MRoundInvalidArgumentException::class);
        new MRounder($may_be_invalid_number, $may_be_invalid_mode);
    }




    public function testInvalidArgumentExceptionOnInvokation(): void
    {
        $mRounder = new MRounder(1);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectException(MRoundInvalidArgumentException::class);
        $mRounder("string");
    }


    public function testUnexpectedValueExceptionOnInvokation(): void
    {
        $mRounder = new MRounder(1);
        // Change the value tgo an invalid value
        $mRounder->mode = "foo";
        $this->expectException(\RuntimeException::class);
        $this->expectException(\UnexpectedValueException::class);
        $this->expectException(MRoundUnexpectedValueException::class);
        $mRounder([2]);
    }


    /**
     * @return array<int, array{mixed, float|int, string|null, mixed}>
     */
    public static function provideVariousParameters(): array
    {
        # - input number
        # - multiple
        # - rounding mode
        # - exepceted result
        return [
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
            [ 0.16,       1 / 6,          null,              1 / 6],

            [ [1,2],      1,            null,              [1,2] ],
            [ [0.5,0.2],  1,            null,              [1,0] ],

            [ ['foo' => 0.5, 'bar' => 0.2],
                1,            null,      ['foo' => 1, 'bar' => 0 ] ],



        ];
    }

    /**
     * @return array<int, array{mixed, mixed}>
     */
    public static function provideInvalidArgumentsForCtor(): array
    {
        return [
            [ "string", null ],
            [ 99,       "foo" ],
            [ null,     null ],
        ];
    }
}
