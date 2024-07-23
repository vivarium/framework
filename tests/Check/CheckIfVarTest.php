<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Test\Check;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Check\CheckIfVar;

/** @coversDefaultClass \Vivarium\Check\CheckIfVar */
final class CheckIfVarTest extends TestCase
{
    /** @covers ::isArray() */
    public function testIsArray(): void
    {
        static::assertTrue(CheckIfVar::isArray([]));
        static::assertFalse(CheckIfVar::isArray(41));
    }

    /** @covers ::isBoolean() */
    public function testIsBoolean(): void
    {
        static::assertTrue(CheckIfVar::isBoolean(true));    
        static::assertTrue(CheckIfVar::isBoolean(false));
        static::assertFalse(CheckIfVar::isBoolean(42));    
    }

    /** @covers ::isCallable() */
    public function testIsCallable(): void
    {
        static::assertTrue(CheckIfVar::isCallable(function () {}));
        static::assertFalse(CheckIfVar::isCallable(42));
    }

    /** @covers ::isFloat() */
    public function testIsFloat(): void
    {
        static::assertTrue(CheckIfVar::isFloat(3.5));
        static::assertFalse(CheckIfVar::isFloat('Hello World'));
    }

    /** @covers ::isInteger() */
    public function testIsInteger(): void
    {
        static::assertTrue(CheckIfVar::isInteger(42));
        static::assertFalse(CheckIfVar::isInteger('Hello World'));
    }

    /** @covers ::isNumeric() */
    public function testIsNumeric(): void
    {
        static::assertTrue(CheckIfVar::isNumeric(3.5));
        static::assertTrue(CheckIfVar::isNumeric(42));
        static::assertFalse(CheckIfVar::isNumeric('42'));
    }

    /** @covers ::isObject() */
    public function testIsObject(): void
    {
        static::assertTrue(CheckIfVar::isObject(new stdClass()));
        static::assertFalse(CheckIfVar::isObject(42));
    }

    /** @covers ::isString() */
    public function testIsString(): void
    {
        static::assertTrue(CheckIfVar::isString('Hello World'));
        static::assertFalse(CheckIfVar::isString(42));
    }
}
