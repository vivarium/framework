<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Test\Check;

use PHPUnit\Framework\TestCase;
use Vivarium\Check\CheckIfString;

/** @coversDefaultClass \Vivarium\Check\CheckIfString */
final class CheckIfStringTest extends TestCase
{
    /**
     * @covers ::contains()
     * 
     * @dataProvider Vivarium\Test\Assertion\String\ContainsTest::provideSuccess()
     */
    public function testContains($string, $substring): void 
    {
        static::assertTrue(CheckIfString::contains($string, $substring));
    }

    /**
     * @covers ::contains()
     * 
     * @dataProvider Vivarium\Test\Assertion\String\ContainsTest::provideFailure()
     */
    public function testContainsFailure($string, $substring): void
    {
        static::assertFalse(CheckIfString::contains($string, $substring));
    }
}
