<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Comparison;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vivarium\Assertion\Comparison\IsOneOf;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Equality\Equal;
use Vivarium\Test\Equality\Stub\EqualityStub;

/** @coversDefaultClass \Vivarium\Assertion\Comparison\IsOneOf */
final class IsOneOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     * 
     * @dataProvider provideSuccess()
     */
    public function testAssert(mixed $value, array $values): void
    {
        static::expectNotToPerformAssertions();

        $oneOf = new IsOneOf($values);

        $oneOf->assert($value);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     * 
     * @dataProvider provideFailure()
     */
    public function testAssertException(mixed $value, array $values, string $message): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage($message);

        (new IsOneOf($values))
            ->assert($value);
    }

    public static function provideSuccess(): array
    {
        $stdClass = new stdClass();

        return [
            [1, [1, 5, 7, 42]],
            [5, [1, 5, 7, 42]],
            [7, [1, 5, 7, 42]],
            [42, [1, 5, 7, 42]],
            [new EqualityStub(), [new EqualityStub(), new EqualityStub()]],
            [$stdClass, [new stdClass, $stdClass]]
        ];
    }

    public static function provideFailure(): array
    {
        return [
            [27, [1, 5, 7, 42], 'Expected value to be one of the values provided. Got 27.']    
        ];
    }
}
