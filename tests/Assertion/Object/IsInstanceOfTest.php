<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Object;

use PHPUnit\Framework\TestCase;
use stdClass;
use Traversable;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Object\IsInstanceOf;
use Vivarium\Test\Assertion\Stub\Stub;

/** @coversDefaultClass \Vivarium\Assertion\Object\IsInstanceOf */
final class IsInstanceOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        $stub = $this->createMock(Traversable::class);

        (new IsInstanceOf(Traversable::class))
            ->assert($stub);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected object to be instance of "Traversable". Got "stdClass".');

        (new IsInstanceOf(Traversable::class))
            ->assert(new stdClass());
    }

    /** @covers ::__construct() */
    public function testConstructorWithoutClass(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Argument must be a class or interface name. Got "RandomString"');

        /**
         * This is covered by static analysis, but it is a valid runtime call
         *
         * @psalm-suppress ArgumentTypeCoercion
         * @psalm-suppress UndefinedClass
         * @phpstan-ignore-next-line
         */
        (new IsInstanceOf('RandomString'))
            ->assert(new stdClass());
    }

    /** @covers ::__construct() */
    public function testAssertWithoutObject(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be object. Got string.');

        (new IsInstanceOf(Stub::class))
            ->assert('Random');
    }
}
