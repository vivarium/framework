<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

use Vivarium\Assertion\String\Contains;
use Vivarium\Assertion\String\EndsWith;
use Vivarium\Assertion\String\IsBasicType;
use Vivarium\Assertion\String\IsClass;
use Vivarium\Assertion\String\IsClassOrInterface;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\String\IsInterface;
use Vivarium\Assertion\String\IsIntersection;
use Vivarium\Assertion\String\IsLong;
use Vivarium\Assertion\String\IsLongAtLeast;
use Vivarium\Assertion\String\IsLongAtMax;
use Vivarium\Assertion\String\IsLongBetween;
use Vivarium\Assertion\String\IsNamespace;
use Vivarium\Assertion\String\IsNotEmpty;
use Vivarium\Assertion\String\IsPrimitive;
use Vivarium\Assertion\String\IsType;
use Vivarium\Assertion\String\IsUnion;
use Vivarium\Assertion\String\StartsWith;

final class CheckIfString
{
    public static function contains(string $string, string $substring): bool
    {
        return (new Contains($substring))($string);
    }

    public static function endsWith(string $string, string $end): bool
    {
        return (new EndsWith($end))($string);
    }

    /** @psalm-assert-if-true 'int'|'float'|'string'|'array'|'callable'|'object'|class-string $string */
    public static function isBasicType(string $string): bool
    {
        return (new IsBasicType())($string);
    }

    /** @psalm-assert-if-true class-string $string */
    public static function isClass(string $string): bool
    {
        return (new IsClass())($string);
    }

    /** @psalm-assert-if-true class-string $string */
    public static function isClassOrInterface(string $string): bool
    {
        return (new IsClassOrInterface())($string);
    }

    public static function isEmpty(string $string): bool
    {
        return (new IsEmpty())($string);
    }

    /** @psalm-assert-if-true class-string $string */
    public static function isInterface(string $string): bool
    {
        return (new IsInterface())($string);
    }

    public static function isIntersection(string $string): bool
    {
        return (new IsIntersection())($string);
    }

    public static function isLong(string $string, int $length, string $encoding = 'UTF-8'): bool
    {
        return (new IsLong($length, $encoding))($string);
    }

    public static function isLongAtLeast(string $string, int $length, string $encoding = 'UTF-8'): bool
    {
        return (new IsLongAtLeast($length, $encoding))($string);
    }

    public static function isLongAtMax(string $string, int $length, string $encoding = 'UTF-8'): bool
    {
        return (new IsLongAtMax($length, $encoding))($string);
    }

    public static function isLongBetween(string $string, int $min, int $max, string $encoding = 'UTF-8'): bool
    {
        return (new IsLongBetween($min, $max, $encoding))($string);
    }

    public static function isNamespace(string $string): bool
    {
        return (new IsNamespace())($string);
    }

    public static function isNotEmpty(string $string): bool
    {
        return (new IsNotEmpty())($string);
    }

    public static function isPrimitive(string $string): bool
    {
        return (new IsPrimitive())($string);
    }

    public static function isType(string $string): bool
    {
        return (new IsType())($string);
    }

    public static function isUnion(string $string): bool
    {
        return (new IsUnion())($string);
    }

    public static function startsWith(string $string, string $start): bool
    {
        return (new StartsWith($start))($string);
    }
}
