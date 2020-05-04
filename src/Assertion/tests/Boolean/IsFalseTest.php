<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Boolean;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Boolean\IsFalse;

/**
 * @coversDefaultClass \Vivarium\Assertion\Boolean\IsFalse
 */
final class IsFalseTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert() : void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected boolean to be false. Got true');

        (new IsFalse())->assert(false);
        (new IsFalse())->assert(true);
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutBoolean() : void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be boolean. Got integer.');

        (new IsFalse())->assert(42);
    }
}
