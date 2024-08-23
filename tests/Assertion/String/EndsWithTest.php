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
use Vivarium\Assertion\String\EndsWith;

/** @coversDefaultClass \Vivarium\Assertion\String\EndsWith */
class EndsWithTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * 
     * @dataProvider provideSuccess()
     */
    public function testAssert($string, $end): void
    {
        static::expectNotToPerformAssertions();

        (new EndsWith($end))
            ->assert($string);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * 
     * @dataProvider provideFailure()
     */
    public function testAssertException($string, $end, $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new EndsWith($end))
            ->assert($string);
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * 
     * @dataProvider provideSuccess()
     */
    public function testInvoke($string, $end): void
    {
        static::assertTrue((new EndsWith($end))($string));
    }

    /**
     * @covers ::__construct()
     * @covers ::__invoke()
     * 
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure($string, $end): void
    {
        static::assertFalse((new EndsWith($end))($string));
    }

    /** @covers ::assert() */
    public function testAssertWithoutString(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be string. Got integer.');

        (new EndsWith('Hello'))
            ->assert(42);
    }

    public static function provideSuccess(): array
    {
        return [
            ['Hello World', 'd'],
            ['Hello World', ' World']
        ];
    }

    public static function provideFailure(): array
    {
        return [
            ['Foo Bar', 'd', 'Expected that string "Foo Bar" ends with "d".']
        ];
    }
}
