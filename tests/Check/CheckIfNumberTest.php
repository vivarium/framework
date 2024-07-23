<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Test\Check;

use PHPUnit\Framework\TestCase;
use Vivarium\Check\CheckIfNumber;

/** @coversDefaultClass \Vivarium\Check\CheckIfNumber */
final class CheckIfNumberTest extends TestCase
{
    /** @covers ::isGreaterOrEqualThan() */
    public function testIsGreaterOrEqualThan(): void
    {
        static::assertTrue(CheckIfNumber::isGreaterOrEqualThan(5, 3));
        static::assertTrue(CheckIfNumber::isGreaterOrEqualThan(3, 3));
        static::assertFalse(CheckIfNumber::isGreaterOrEqualThan(3, 5));
    }

    /** @covers ::isGreaterThan() */
    public function testIsGreaterThan(): void
    {
        static::assertTrue(CheckIfNumber::isGreaterThan(5, 3));
        static::assertFalse(CheckIfNumber::isGreaterThan(3, 3));
        static::assertFalse(CheckIfNumber::isGreaterThan(3, 5));
    }

    /** @covers ::isInClosedRange() */
    public function testIsInClosedRange(): void
    {
        static::assertTrue(CheckIfNumber::isInClosedRange(5, 0, 9));
        static::assertTrue(CheckIfNumber::isInClosedRange(0, 0, 9));
        static::assertTrue(CheckIfNumber::isInClosedRange(9, 0, 9));
        static::assertFalse(CheckIfNumber::isInClosedRange(10, 0, 9));
    }

    /** @covers ::isInHalfOpenRightRange() */
    public function testIsInHalfOpenRightRange(): void
    {
        static::assertTrue(CheckIfNumber::isInHalfOpenRightRange(5, 0, 9));
        static::assertTrue(CheckIfNumber::isInHalfOpenRightRange(0, 0, 9));
        static::assertFalse(CheckIfNumber::isInHalfOpenRightRange(9, 0, 9));
        static::assertFalse(CheckIfNumber::isInHalfOpenRightRange(10, 0, 9));
    }

    /** @covers ::isInOpenRange() */
    public function testIsInOpenRange(): void
    {
        static::assertTrue(CheckIfNumber::isInOpenRange(5, 0, 9));
        static::assertFalse(CheckIfNumber::isInOpenRange(0, 0, 9));
        static::assertFalse(CheckIfNumber::isInOpenRange(9, 0, 9));
        static::assertFalse(CheckIfNumber::isInOpenRange(10, 0, 9));
    }

    /** @covers ::isLessOrEqualThan() */
    public function testIsLessOrEqualThan(): void
    {
        static::assertTrue(CheckIfNumber::isLessOrEqualThan(3, 5));
        static::assertTrue(CheckIfNumber::isLessOrEqualThan(5, 5));
        static::assertFalse(CheckIfNumber::isLessOrEqualThan(6, 5));
    }

    /** @covers ::isLessThan() */
    public function testIsLessThan(): void
    {
        static::assertTrue(CheckIfNumber::isLessThan(3, 5));
        static::assertFalse(CheckIfNumber::isLessThan(5, 5));
        static::assertFalse(CheckIfNumber::isLessThan(6, 5));
    }

    /** @covers ::isOutOfClosedRange() */
    public function testIsOutOfClosedRange(): void
    {
        static::assertTrue(CheckIfNumber::isOutOfClosedRange(10, 0, 9));
        static::assertFalse(CheckIfNumber::isOutOfClosedRange(5, 0, 9));
        static::assertFalse(CheckIfNumber::isOutOfClosedRange(0, 0, 9));
        static::assertFalse(CheckIfNumber::isOutOfClosedRange(9, 0, 9));
    }

    /** @covers ::isOutOfOpenRange() */
    public function testIsOutOfOpenRange(): void
    {
        static::assertTrue(CheckIfNumber::isOutOfOpenRange(10, 0, 9));
        static::assertTrue(CheckIfNumber::isOutOfOpenRange(0, 0, 9));
        static::assertTrue(CheckIfNumber::isOutOfOpenRange(9, 0, 9));
        static::assertFalse(CheckIfNumber::isOutOfOpenRange(5, 0, 9));
    }
}
