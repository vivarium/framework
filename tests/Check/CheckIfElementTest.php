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
use Vivarium\Check\CheckIfElement;

/** @coversDefaultClass \Vivarium\Check\CheckIfElement */
final class CheckIfElementTest extends TestCase
{
    /** @covers ::isEqualTo() */
    public function testEqualTo(): void
    {
        static::assertTrue(CheckIfElement::isEqualTo(5, 5));
        static::assertFalse(CheckIfElement::isEqualTo(2, 'str'));
    }

    /** @covers ::isOneOf() */
    public function testIsOneOf(): void
    {
        $choices = [1,2,3,4,5];

        static::assertTrue(CheckIfElement::isOneOf(5, ...$choices));
        static::assertFalse(CheckIfElement::isOneOf(7, ...$choices));
    }

    /** @covers ::isSameOf() */
    public function testIsSameOf(): void
    {
        $stdClass = new stdClass();
        
        static::assertTrue(CheckIfElement::isSameOf($stdClass, $stdClass));
        static::assertFalse(CheckIfElement::isSameOf($stdClass, new stdClass()));
    }
}
