<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Type;

use PHPUnit\Framework\TestCase;
use stdClass;
use Traversable;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\ImplementsInterface;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;

/** @coversDefaultClass \Vivarium\Assertion\Type\ImplementsInterface */
final class ImplementsInterfaceTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @dataProvider provideSuccess()
     */
    public function testAssert(string $class, string $interface): void
    {
        static::expectNotToPerformAssertions();

        (new ImplementsInterface($interface))
            ->assert($class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @dataProvider provideFailure()
     * @dataProvider provideInvalid()
     */
    public function testAssertException(string $class, string $interface, string $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new ImplementsInterface($interface))
            ->assert($class);
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * @dataProvider provideSuccess()
     */
    public function testInvoke(string $class, string $interface): void
    {
        static::assertTrue(
            (new ImplementsInterface($interface))($class),
        );
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure(string $class, string $interface): void
    {
        static::assertFalse(
            (new ImplementsInterface($interface))($class),
        );
    }

    public static function provideSuccess(): array
    {
        return [
            [StubClass::class, Stub::class],
        ];
    }

    public static function provideFailure(): array
    {
        return [
            [
                stdClass::class,
                Traversable::class,
                'Expected class "stdClass" to implements "Traversable".',
            ],
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            [
                stdClass::class,
                stdClass::class,
                'Expected string to be interface name. Got "stdClass".',
            ],
            [
                Traversable::class,
                Traversable::class,
                'Expected string to be class name. Got "Traversable".',
            ],
        ];
    }
}
