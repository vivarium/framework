<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Test\Check;

use Vivarium\Check\CheckIfVar;

/** @coversDefaultClass \Vivarium\Check\CheckIfVar */
final class CheckIfVarTest extends CheckTestCase
{
    const NAMESPACE = 'Vivarium\Test\Assertion\Var';

    /**
     * @covers ::__callStatic()
     * 
     * @dataProvider provideMethods()
     */
    public function testCallStatic(string $method): void
    {
        $this->doTest(
            CheckIfVar::class,
            $method,
            static::NAMESPACE
        );
    }

    public static function provideMethods(): array
    {
        return [
            ['isArray'],
            ['isBoolean'],
            ['isCallable'],
            ['isFloat'],
            ['isInteger'],
            ['isNumeric'],
            ['isObject'],
            ['isString'],
        ];
    }
}
