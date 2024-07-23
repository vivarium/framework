<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Test\Check;

use PHPUnit\Framework\TestCase;
use stdClass;
use Traversable;
use Vivarium\Check\CheckIfType;
use Vivarium\Test\Assertion\Stub\InvokableStub;
use Vivarium\Test\Assertion\Stub\Stub;
use Vivarium\Test\Assertion\Stub\StubClass;
use Vivarium\Test\Assertion\Stub\StubClassExtension;

/** @coversDefaultClass \Vivarium\Check\CheckIfType */
final class CheckIfTypeTest extends TestCase
{
    /** @covers ::implementsInterface() */
    public function testImplementsInterface(): void
    {
        $mock = $this->createMock(Traversable::class);

        static::assertTrue(CheckIfType::implementsInterface($mock::class, Traversable::class));
        static::assertFalse(CheckIfType::implementsInterface(stdClass::class, Traversable::class));
    }

    /** @covers ::isAssignableTo() */
    public function testIsAssignableTo(): void
    {
        $types = [
            [Stub::class, Stub::class],
            [Stub::class, StubClass::class],
            [Stub::class, StubClassExtension::class],
            [StubClass::class, StubClassExtension::class],
            ['float', 'int'],
            ['string', 'string'],
            ['callable', InvokableStub::class],
            ['string', StubClass::class],
            ['stdClass|' . StubClass::class, 'stdClass'],
            ['stdClass|' . StubClass::class, StubClassExtension::class],
            [Stub::class . '&' . InvokableStub::class, StubClassExtension::class],
        ];

        foreach ($types as $type) {
            static::assertTrue(CheckIfType::isAssignableTo($type[1], $type[0]));
        }

        static::assertFalse(CheckIfType::isAssignableTo(Stub::class, StubClassExtension::class));
    }

    /** @covers ::isAssignableToClass() */
    public function testIsAssignableToClass(): void
    {
        static::assertTrue(CheckIfType::isAssignableToClass(Stub::class, Stub::class));
        static::assertTrue(CheckIfType::isAssignableToClass(StubClass::class, Stub::class));
        static::assertFalse(CheckIfType::isAssignableToClass(Stub::class, stdClass::class));
    }

    /** @covers ::isAssignableToIntersection() */
    public function isAssignableToIntersection(): void
    {
        $intersection = Stub::class . '&' . InvokableStub::class;

        static::assertTrue(CheckIfType::isAssignableToIntersection(StubClassExtension::class, $intersection));
        static::assertFalse(CheckIfType::isAssignableToIntersection(Stub::class, $intersection));
    }

    /** @covers ::isAssignableToPrimitive() */
    public function testIsAssignableToPrimitive(): void
    {
        $types = [
            ['float', 'int'],
            ['string', 'string'],
            ['string', StubClass::class],
            ['object', StubClass::class],
            ['callable', StubClassExtension::class],
        ];

        foreach ($types as $type) {
            static::assertTrue(CheckIfType::isAssignableToPrimitive($type[1], $type[0]));
        }

        static::assertFalse(CheckIfType::isAssignableTo(stdClass::class, 'int'));
    }

    /** @covers ::isAssignableToUnion() */
    public function testIsAssignableToUnion(): void
    {
        $union = $union = 'stdClass|' . StubClass::class;

        static::assertTrue(CheckIfType::isAssignableToUnion(stdClass::class, $union));
        static::assertTrue(CheckIfType::isAssignableToUnion(StubClass::class, $union));
        static::assertFalse(CheckIfType::isAssignableToUnion('int', $union));
    }

    /** @covers ::isSubclassOf() */
    public function testIsSubclassOf(): void
    {
        static::assertTrue(CheckIfType::isSubclassOf(StubClass::class, Stub::class));
        static::assertFalse(CheckIfType::isSubclassOf(Stub::class, stdClass::class));
    }
}
