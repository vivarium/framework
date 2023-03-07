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
use Vivarium\Assertion\Comparison\IsSameOf;
use Vivarium\Assertion\Exception\AssertionFailed;

/** @coversDefaultClass \Vivarium\Assertion\Comparison\IsSameOf */
final class IsSameOfTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssert(): void
    {
        static::expectNotToPerformAssertions();

        (new IsSameOf(42))
            ->assert(42);

        $stdClass = new stdClass();
        (new IsSameOf($stdClass))
            ->assert($stdClass);
    }

    /**
     * @covers ::__construct()
     * @covers ::assert()
     * @covers ::__invoke()
     */
    public function testAssertException(): void
    {
        static::expectException(AssertionFailed::class);
        static::expectExceptionMessage('Expected value to be the same of "stdClass". Got different object.');

        (new IsSameOf(new stdClass()))
            ->assert(new stdClass());
    }
}
