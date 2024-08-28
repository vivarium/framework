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
use Vivarium\Assertion\Type\IsSubclassOf;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;
use Vivarium\Test\Assertion\Stub\StubClassExtension;

use function sprintf;

/** @coversDefaultClass \Vivarium\Assertion\Type\IsSubclassOf */
final class IsSubclassOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * 
     * @dataProvider provideSuccess()
     */
    public function testAssert(string $class, string $subclass): void
    {
        static::expectNotToPerformAssertions();

        (new IsSubclassOf($subclass))
            ->assert($class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * 
     * @dataProvider provideFailure()
     * @dataProvider provideInvalid()
     */
    public function testAssertException(string $class, string $subclass, string $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new IsSubclassOf($subclass))
            ->assert($class);
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * 
     * @dataProvider provideSuccess()
     */
    public function testInvoke(string $class, string $subclass): void
    {
        static::assertTrue(
            (new IsSubclassOf($subclass))($class)
        );
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * 
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure(string $class, string $subclass): void
    {
        static::assertFalse(
            (new IsSubclassOf($subclass))($class)
        );
    }

    public static function provideSuccess(): array
    {
        return [
            [
                StubClass::class, 
                Stub::class
            ],
            [
                StubClassExtension::class,
                StubClass::class
            ]
        ];
    }

    public static function provideFailure(): array
    {
        return [
            [
                StubClass::class,
                StubClassExtension::class,
                sprintf(
                    'Expected class "%s" to be subclass of "%2$s".',
                    StubClass::class,
                    StubClassExtension::class,
                ),
            ],
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            [
                'RandomString',
                StubClass::class,
                'Expected string to be class or interface name. Got "RandomString"'
            ],
            [
                StubClass::class,
                'RandomString',
                'Expected string to be class or interface name. Got "RandomString"'
            ]
        ];
    }
}
