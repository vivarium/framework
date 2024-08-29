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
use Vivarium\Assertion\Type\IsClass;

/** @coversDefaultClass \Vivarium\Assertion\Type\IsClass */
final class IsClassTest extends TestCase
{
    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        (new IsClass())
            ->assert('stdClass');
    }

    /**
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be a class name. Got "Foo".');

        (new IsClass())
            ->assert('Foo');
    }

    /** @covers ::assert() */
    public function testAssertWithoutString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        (new IsClass())
            ->assert(42);
    }
}
