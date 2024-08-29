<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Numeric;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Numeric\IsOutOfClosedRange;

/** @coversDefaultClass \Vivarium\Assertion\Numeric\IsOutOfClosedRange */
final class IsOutOfClosedRangeTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @dataProvider provideSuccess()
     */
    public function testAssert(int|float $number, int|float $min, int|float $max): void
    {
        static::expectNotToPerformAssertions();

        (new IsOutOfClosedRange($min, $max))
        ->assert($number);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @dataProvider provideFailure()
     * @dataProvider provideInvalid()
     */
    public function testAssertException(int|float|string $number, int|float $min, int|float $max, string $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new IsOutOfClosedRange($min, $max))
            ->assert($number);
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * @dataProvider provideSuccess()
     */
    public function testInvoke(int|float $number, int|float $min, int|float $max): void
    {
        static::assertTrue(
            (new IsOutOfClosedRange($min, $max))($number),
        );
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure(int|float $number, int|float $min, int|float $max): void
    {
        static::assertFalse(
            (new IsOutOfClosedRange($min, $max))($number),
        );
    }

    public static function provideSuccess(): array
    {
        return [
            [10, 0, 9],
            [-1, 0, 9],
            [42, 0, 9],
        ];
    }

    public static function provideFailure(): array
    {
        return [
            [5, 0, 9, 'Expected number to be out of closed range [0, 9]. Got 5.'],
            [1, 0, 9, 'Expected number to be out of closed range [0, 9]. Got 1.'],
            [8, 0, 9, 'Expected number to be out of closed range [0, 9]. Got 8.'],
            [8.999, 0, 9, 'Expected number to be out of closed range [0, 9]. Got 8.999.'],
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            [11, 10, 0, 'Lower bound must be lower than upper bound. Got [10, 0].'],
            ['String', 0, 10, 'Expected value to be either integer or float. Got string.'],
        ];
    }
}
