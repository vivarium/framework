<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type\Test;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Type\Native;

/**
 * @coversDefaultClass \Vivarium\Type\Native
 */
final class NativeTest extends TestCase
{
    /**
     * @covers ::integer()
     */
    public function testInteger() : void
    {
        static::assertTrue(
            Native::integer()->acceptVar(42)
        );

        static::assertFalse(
            Native::integer()->acceptVar('Foo')
        );
    }

    /**
     * @covers ::float()
     */
    public function testFloat() : void
    {
        static::assertTrue(
            Native::float()->acceptVar(0.42)
        );

        static::assertFalse(
            Native::float()->acceptVar('Bar')
        );
    }

    /**
     * @covers ::string()
     */
    public function testString() : void
    {
        static::assertTrue(
            Native::string()->acceptVar('Foo')
        );

        static::assertFalse(
            Native::string()->acceptVar(42)
        );
    }

    /**
     * @covers ::mixed()
     */
    public function testMixed() : void
    {
        static::assertTrue(
            Native::mixed()->acceptVar(new stdClass())
        );

        static::assertTrue(
            Native::mixed()->acceptVar(42)
        );

        static::assertTrue(
            Native::mixed()->acceptVar('Foo')
        );
    }
}
