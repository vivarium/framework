<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Test\Type;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Type\IsNumeric;

/**
 * @coversDefaultClass \Vivarium\Assertion\Type\IsNumeric
 */
final class IsNumericTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert() : void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Expected value to be either integer or float. Got "42".');

        (new IsNumeric())(3.14);
        (new IsNumeric())->assert(42);
        (new IsNumeric())->assert('42');
    }
}
