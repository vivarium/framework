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
use Vivarium\Check\CheckIfEncoding;

/** @coversDefaultClass \Vivarium\Check\CheckIfEncoding */
final class CheckIfEncodingTest extends TestCase
{
    /** @covers ::isValid() */
    public function testIsValid(): void
    {
        static::assertTrue(CheckIfEncoding::isValid('UTF-8'));
        static::assertFalse(CheckIfEncoding::isValid('Windows-1251'));
    }

    /** @covers ::isValidForRegex() */
    public function testIsValidForRegex(): void
    {
        static::assertTrue(CheckIfEncoding::isValidForRegex('UTF-8'));
        static::assertFalse(CheckIfEncoding::isValidForRegex('Windows-1251'));
    }

    /** @covers ::isValidForSystem() */
    public function testIsValidForSystem(): void
    {
        static::assertTrue(CheckIfEncoding::isValidForSystem('Windows-1251'));
        static::assertFalse(CheckIfEncoding::isValidForSystem('Foo'));
    }
}
