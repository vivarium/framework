<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type\Test;

use PHPUnit\Framework\TestCase;
use Vivarium\Type\Clazz;
use Vivarium\Type\Func;
use Vivarium\Type\Native;
use Vivarium\Type\Test\Stub\Foo;
use Vivarium\Type\Tuple;

/**
 * @coversDefaultClass \Vivarium\Type\Func
 */
final class FuncTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::accept()
     */
    public function testAccept() : void
    {
        $func1 = new Func(
            new Tuple(
                Native::integer(),
                new Clazz(Foo::class)
            )
        );

        $func2 = new Func(
            new Tuple(
                Native::integer(),
                new Clazz(Foo::class)
            )
        );

        static::assertFalse($func1->accept(Native::integer()));
        static::assertTrue($func1->accept($func2));
    }

    /**
     * @covers ::acceptVar()
     * @covers ::extractParameter()
     */
    public function testAcceptVar() : void
    {
        $func = new Func(
            new Tuple(
                Native::integer(),
                new Clazz(Foo::class)
            )
        );

        static::assertTrue(
            $func->acceptVar(
                static function (int $a, Foo $b) : void {
                }
            )
        );

        static::assertFalse(
            $func->acceptVar(
                static function (string $a, string $b) : void {
                }
            )
        );

        static::assertFalse(
            $func->acceptVar(
                static function (float $a, string $b) : void {
                }
            )
        );

        static::assertFalse(
            $func->acceptVar(
                static function ($a) : void {
                }
            )
        );

        static::assertFalse(
            $func->acceptVar(
                static function ($a, $b) : void {
                }
            )
        );

        static::assertFalse(
            $func->acceptVar(42)
        );
    }
}
