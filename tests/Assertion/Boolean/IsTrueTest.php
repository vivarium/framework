<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Boolean;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Boolean\IsTrue;

/**
 * @coversDefaultClass \Vivarium\Assertion\Boolean\IsTrue
 */
final class IsTrueTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected boolean to be true. Got false.');

        (new IsTrue())->assert(true);
        (new IsTrue())->assert(false);
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutBoolean(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be boolean. Got integer.');

        (new IsTrue())->assert(42);
    }
}
