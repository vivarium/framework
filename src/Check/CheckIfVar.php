<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

use Vivarium\Assertion\Var\IsArray;
use Vivarium\Assertion\Var\IsCallable;
use Vivarium\Assertion\Var\IsFloat;
use Vivarium\Assertion\Var\IsInteger;
use Vivarium\Assertion\Var\IsNumeric;
use Vivarium\Assertion\Var\IsObject;
use Vivarium\Assertion\Var\IsString;

final class CheckIfVar
{
    /** @psalm-assert-if-true array $var */
    public static function isArray(mixed $var): bool
    {
        return (new IsArray())($var);
    }

    /** @psalm-assert-if-true array $var */
    public static function isBoolean(mixed $var): bool
    {
        return (new IsArray())($var);
    }

    /** @psalm-assert-if-true callable $var */
    public static function isCallable(mixed $var): bool
    {
        return (new IsCallable())($var);
    }

    /** @psalm-assert-if-true float $var */
    public static function isFloat(mixed $var): bool
    {
        return (new IsFloat())($var);
    }

    /** @psalm-assert-if-true int $var */
    public static function isInteger(mixed $var): bool
    {
        return (new IsInteger())($var);
    }

    /** @psalm-assert-if-true numeric $var */
    public static function isNumeric(mixed $var): bool
    {
        return (new IsNumeric())($var);
    }

    /** @psalm-assert-if-true object $var */
    public static function isObject(mixed $var): bool
    {
        return (new IsObject())($var);
    }

    /** @psalm-assert-if-true string $var */
    public static function isString(mixed $var): bool
    {
        return (new isString())($var);
    }
}
