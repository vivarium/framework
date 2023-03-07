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
use Vivarium\Assertion\Numeric\IsLessOrEqualThan;

/** @coversDefaultClass \Vivarium\Assertion\Numeric\IsLessOrEqualThan */
final class IsLessOrEqualThanTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        (new IsLessOrEqualThan(10))
            ->assert(10);

        (new IsLessOrEqualThan(10))
            ->assert(5);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected number to be less or equal than 10. Got 42.');

        (new IsLessOrEqualThan(10))
            ->assert(42);
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutNumeric(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be either integer or float. Got "String".');

        (new IsLessOrEqualThan(10))
            ->assert('String');
    }
}
