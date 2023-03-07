<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Comparison;

use PHPUnit\Framework\TestCase;
use Vivarium\Assertion\Comparison\IsOneOf;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Equality\Equality;

/** @coversDefaultClass \Vivarium\Assertion\Comparison\IsOneOf */
final class IsOneOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        $oneOf = new IsOneOf(1, 5, 7, 42);

        $oneOf->assert(1);
        $oneOf->assert(5);
        $oneOf->assert(7);
        $oneOf->assert(42);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be one of the values provided. Got 27.');

        (new IsOneOf(1, 5, 7, 42))
            ->assert(27);
    }
}
