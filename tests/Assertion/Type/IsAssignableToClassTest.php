<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Type;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\IsAssignableToClass;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;
use Vivarium\Test\Assertion\Stub\StubClassExtension;

use function sprintf;

/** @coversDefaultClass \Vivarium\Assertion\Type\IsAssignableToClass */
final class IsAssignableToClassTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * 
     * @dataProvider provideSuccess()
     */
    public function testAssert(string $class, string $interface): void
    {
        static::expectNotToPerformAssertions();

        (new IsAssignableToClass($interface))
            ->assert($class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * 
     * @dataProvider provideFailure()
     * @dataProvider provideInvalid()
     */
    public function testAssertException(string $class, string $interface, string $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new IsAssignableToClass($interface))
            ->assert($class);
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * 
     * @dataProvider provideSuccess()
     */
    public function testInvoke(string $class, string $interface): void
    {
        static::assertTrue(
            (new IsAssignableToClass($interface))($class)
        );
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * 
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure(string $class, string $interface): void
    {
        static::assertFalse(
            (new IsAssignableToClass($interface))($class)
        );
    }

    public static function provideSuccess(): array
    {
        return [
            [Stub::class, Stub::class],
            [StubClass::class, Stub::class],
            [StubClassExtension::class, StubClass::class]
        ];
    }

    public static function provideFailure(): array
    {
        return [
            [
                StubClass::class, 
                StubClassExtension::class, 
                sprintf(
                    'Expected class "%s" to be assignable to "%2$s".',
                    StubClass::class,
                    StubClassExtension::class,
                )
            ]
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            [
                StubClass::class, 
                'RandomString', 
                'Expected string to be class or interface name. Got "RandomString"'
            ],
            [
                'RandomString', 
                StubClass::class, 
                'Expected string to be class or interface name. Got "RandomString"'
            ]
        ];
    }
}
