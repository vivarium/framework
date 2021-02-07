<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Hierarchy;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Hierarchy\IsSubclassOf;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;
use Vivarium\Test\Assertion\Stub\StubClassExtension;

use function sprintf;

/**
 * @coversDefaultClass \Vivarium\Assertion\Hierarchy\IsSubclassOf
 */
final class IsSubclassOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage(
            sprintf(
                'Expected class "%s" to be subclass of "%2$s".',
                StubClass::class,
                StubClassExtension::class
            )
        );

        (new IsSubclassOf(Stub::class))->assert(StubClass::class);
        (new IsSubclassOf(StubClass::class))->assert(StubClassExtension::class);
        (new IsSubclassOf(StubClassExtension::class))->assert(StubClass::class);
    }

    /**
     * @covers ::__construct()
     */
    public function testConstructorWithoutClass(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Argument must be a class or interface name. Got "RandomString"');

        (new IsSubclassOf('RandomString'))->assert(Stub::class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutClass(): void
    {
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Argument must be a class or interface name. Got "RandomString"');

        (new IsSubclassOf(Stub::class))->assert('RandomString');
    }
}
