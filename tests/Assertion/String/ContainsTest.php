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
     * 
     * @dataProvider provideSuccess()
     */
    public function testAssert($string, $substring): void
    {
        static::expectNotToPerformAssertions();

        (new Contains($substring))
            ->assert($string);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * 
     * @dataProvider provideFailure()
     */
    public function testAssertException($string, $substring, $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new Contains($substring))
            ->assert($string);
    }

    /**
     * @covers ::__construct() 
     * @covers ::__invoke()
     * 
     * @dataProvider provideSuccess()
     */
    public function testInvoke($string, $substring): void
    {
        static::assertTrue((new Contains($substring))($string));
    }

    /**
     * @covers ::__construct() 
     * @covers ::__invoke()
     * 
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure($string, $substring): void
    {
        static::assertFalse((new Contains($substring))($string));
    }

    /** @covers ::assert() */
    public function testAssertWithoutString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        (new Contains('Hello'))
            ->assert(42);
    }

    public static function provideSuccess(): array
    {
        return [
            ['Foo Bar', 'Bar'],
            ['Hello World', 'H'],
            ['Hello World', 'Hello'],
            ['Hello World', 'World'],
            ['Hello World', 'lo Wo'],
            ['Hello World', ' ']
        ];
    }

    public static function provideFailure(): array
    {
        return [
            ['Hello World', 'Foo', 'Expected that string contains "Foo".'],
            ['Hello World', '  ', 'Expected that string contains "  ".']
        ];
    }
}
