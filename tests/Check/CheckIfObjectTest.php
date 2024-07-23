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
use Vivarium\Check\CheckIfObject;
use Vivarium\Test\Assertion\Stub\StubClass;

/** @coversDefaultClass \Vivarium\Check\CheckIfObject */
final class CheckIfObjectTest extends TestCase
{
    /** @covers ::hasMethod() */
    public function testHasMethod(): void
    {
        $stub = new StubClass();

        static::assertTrue(CheckIfObject::hasMethod(StubClass::class, '__toString'));
        static::assertTrue(CheckIfObject::hasMethod($stub, '__toString'));
        static::assertFalse(CheckIfObject::hasMethod(new stdClass(), '__toString'));
    }

    /** @covers ::isInstanceOf() */
    public function testIsInstanceOf(): void
    {
        $stub = $this->createMock(Traversable::class);

        static::assertTrue(CheckIfObject::isInstanceOf($stub, Traversable::class));
        static::assertFalse(CheckIfObject::isInstanceOf(new stdClass(), Traversable::class));
    }
}
