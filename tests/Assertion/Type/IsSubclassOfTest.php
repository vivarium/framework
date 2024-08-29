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
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        (new IsSubclassOf(Stub::class))
            ->assert(StubClass::class);

        (new IsSubclassOf(StubClass::class))
            ->assert(StubClassExtension::class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage(
            sprintf(
                'Expected class "%s" to be subclass of "%2$s".',
                StubClass::class,
                StubClassExtension::class,
            ),
        );

        (new IsSubclassOf(StubClassExtension::class))
            ->assert(StubClass::class);
    }

    /** @covers ::__construct() */
    public function testConstructorWithoutClass(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be class or interface name. Got "RandomString"');

        /**
         * This is covered by static analysis, but it is a valid runtime call
         *
         * @psalm-suppress ArgumentTypeCoercion
         * @psalm-suppress UndefinedClass
         * @phpstan-ignore-next-line
         */
        (new IsSubclassOf('RandomString'))
            ->assert(Stub::class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutClass(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Argument must be a class or interface name. Got "RandomString"');

        (new IsSubclassOf(Stub::class))
            ->assert('RandomString');
    }
}
