<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Encoding;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Encoding\IsEncoding;
use Vivarium\Assertion\Exception\AssertionFailed;

/** @coversDefaultClass \Vivarium\Assertion\Encoding\IsEncoding */
final class IsEncodingTest extends TestCase
{
    /**
     * @covers ::assert()
     * 
     * @dataProvider provideSuccess()
     */
    public function testAssert(string $encoding): void
    {
        static::expectNotToPerformAssertions();

        (new IsEncoding())->assert($encoding);
    }

    /**
     * @covers ::assert()
     * 
     * @dataProvider provideFailure()
     * @dataProvider provideInvalid()
     */
    public function testAssertException(string|int $encoding, string $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new IsEncoding())->assert($encoding);
    }

    /**
     * @covers ::__invoke()
     * 
     * @dataProvider provideSuccess()
     */
    public function testInvoke(string $encoding): void
    {
        static::assertTrue(
            (new IsEncoding())($encoding)
        );
    }

    /**
     * @covers ::__invoke()
     * 
     * @dataProvider provideFailure()
     */
    public function testInvokeFailure(string|int $encoding): void
    {
        static::assertFalse(
            (new IsEncoding())($encoding)
        );
    }

    public static function provideSuccess(): array
    {
        return [
            ['UTF-8'],
            ['UTF-32'],
            ['ASCII']
        ];
    }

    public static function provideFailure(): array
    {
        return [
            ['Windows-1251', '"Windows-1251" is not a valid encoding.']
        ];
    }

    public static function provideInvalid(): array
    {
        return [
            [42, 'Expected value to be string. Got integer.']
        ];
    }
}
