<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Hierarchy;

use PHPUnit\Framework\TestCase;
use stdClass;
use Traversable;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Type\ImplementsInterface;

/** @coversDefaultClass \Vivarium\Assertion\Type\ImplementsInterface */
final class ImplementsInterfaceTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        $mock = $this->createMock(Traversable::class);

        (new ImplementsInterface(Traversable::class))
            ->assert($mock::class);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected class "stdClass" to implements "Traversable".');

        (new ImplementsInterface(Traversable::class))
            ->assert(stdClass::class);
    }

    /** @covers ::assert() */
    public function testAssertWithoutInterface(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be interface name. Got "stdClass".');

        (new ImplementsInterface(stdClass::class))
            ->assert(stdClass::class);
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertWithoutClass(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be a class name. Got "Traversable".');

        (new ImplementsInterface(Traversable::class))
            ->assert(Traversable::class);
    }
}
