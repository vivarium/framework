<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Numeric;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Numeric\IsGreaterOrEqualThan;

/**
 * @coversDefaultClass \Vivarium\Assertion\Numeric\IsGreaterOrEqualThan
 */
final class IsGreaterOrEqualThanTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected number to be greater or equal than 10. Got 3.');

        (new IsGreaterOrEqualThan(10))->assert(10);
        (new IsGreaterOrEqualThan(10))->assert(42);
        (new IsGreaterOrEqualThan(10))->assert(3);
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutNumeric(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be either integer or float. Got "String".');

        (new IsGreaterOrEqualThan(10))->assert('String');
    }
}
