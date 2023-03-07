<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\String;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\String\Contains;

/** @coversDefaultClass \Vivarium\Assertion\String\Contains */
class ContainsTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        (new Contains('Bar'))->assert('Foo Bar');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected that string contains "Hello".');

        (new Contains('Hello'))->assert('Foo Bar');
    }

    /** @covers ::__invoke() */
    public function testInvoke(): void
    {
        static::assertTrue((new Contains('H'))('Hello World'));
        static::assertTrue((new Contains('Hello'))('Hello World'));
        static::assertFalse((new Contains('Foo'))('Hello World'));
    }

    /** @covers ::assert() */
    public function testAssertWithoutString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        (new Contains('Hello'))
            ->assert(42);
    }
}
