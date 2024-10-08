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
use Vivarium\Assertion\String\IsLongBetween;

/**
 * @coversDefaultClass \Vivarium\Assertion\String\IsLongBetween
 */
final class IsLongBetweenTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be long between 5 and 10. Got 11');

        (new IsLongBetween(1, 5))->assert('Hello');
        (new IsLongBetween(2, 5))->assert('Hi');
        (new IsLongBetween(5, 10))->assert('Hello World');
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testIsLongAtLeastWithWrongEncoding(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('"Foo" is not a valid system encoding.');

        (new IsLongBetween(3, 5, 'Foo'))->assert('Hello');
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithoutString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        /**
         * This is covered by static analysis but it is a valid runtime call
         *
         * @psalm-suppress InvalidScalarArgument
         * @phpstan-ignore-next-line
         */
        (new IsLongBetween(0, 5))->assert(42);
    }

    /**
     * @covers ::assert()
     */
    public function testAssertWithMultibyte(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected string to be long between 0 and 1. Got 2.');

        (new IsLongBetween(0, 1, 'UTF-8'))->assert('ππ');
    }

    /**
     * @covers ::assert()
     */
    public function testInvokeWithMultibyte(): void
    {
        static::assertTrue(
            (new IsLongBetween(0, 2, 'UTF-8'))('ππ')
        );
    }
}
