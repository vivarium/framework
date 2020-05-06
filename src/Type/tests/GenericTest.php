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
use Vivarium\Type\Generic;
use Vivarium\Type\Native;
use Vivarium\Type\Test\Stub\Foo;
use Vivarium\Type\Tuple;

/**
 * @coversDefaultClass \Vivarium\Type\Generic
 */
final class GenericTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::acceptVar()
     */
    public function testAcceptVar() : void
    {
        $class = new Clazz(Foo::class);
        $tuple = new Tuple(
            Native::integer(),
            Native::string(),
            new Clazz(stdClass::class)
        );

        $generic = new Generic($class, $tuple);

        static::assertTrue($generic->acceptVar(new Foo()));
        static::assertFalse($generic->acceptVar(new stdClass()));
    }

    /**
     * @covers ::acceptVar()
     */
    public function testAcceptVarFail() : void
    {
        $generic = new Generic(
            new Clazz(stdClass::class),
            new Tuple(Native::integer())
        );

        static::assertFalse($generic->acceptVar(new stdClass()));
    }

    /**
     * @covers ::accept()
     */
    public function testAccept() : void
    {
        $generic1 = new Generic(
            new Clazz(Foo::class),
            new Tuple(
                Native::integer(),
                Native::string(),
                new Clazz(stdClass::class)
            )
        );

        $generic2 = new Generic(
            new Clazz(Foo::class),
            new Tuple(
                Native::integer(),
                Native::string(),
                new Clazz(stdClass::class)
            )
        );

        $generic3 = new Generic(
            new Clazz(Foo::class),
            new Tuple(
                Native::integer()
            )
        );

        static::assertTrue($generic1->accept($generic2));
        static::assertFalse($generic1->accept($generic3));
        static::assertFalse($generic1->accept(Native::mixed()));
    }
}
