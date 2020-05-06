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
use Vivarium\Type\Clazz;
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

        static::assertTrue(
            Native::integer()->accept(
                Native::integer()
            )
        );

        static::assertFalse(
            Native::integer()->accept(
                Native::float()
            )
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

        static::assertTrue(
            Native::float()->accept(
                Native::float()
            )
        );

        static::assertFalse(
            Native::float()->accept(
                Native::integer()
            )
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

        static::assertTrue(
            Native::string()->accept(
                Native::string()
            )
        );

        static::assertFalse(
            Native::string()->accept(
                Native::mixed()
            )
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

        static::assertTrue(
            Native::mixed()->accept(
                Native::mixed()
            )
        );

        static::assertTrue(
            Native::mixed()->accept(
                Native::integer()
            )
        );

        static::assertTrue(
            Native::mixed()->accept(
                Native::float()
            )
        );

        static::assertTrue(
            Native::mixed()->accept(
                Native::string()
            )
        );

        static::assertTrue(
            Native::mixed()->accept(
                new Clazz(stdClass::class)
            )
        );
    }
}
