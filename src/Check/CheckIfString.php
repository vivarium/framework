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
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\String\IsLong;
use Vivarium\Assertion\String\IsLongAtLeast;
use Vivarium\Assertion\String\IsLongAtMax;
use Vivarium\Assertion\String\IsLongBetween;
use Vivarium\Assertion\String\IsNotEmpty;
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

    public static function isEmpty(string $string): bool
    {
        return (new IsEmpty())($string);
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

    public static function isNotEmpty(string $string): bool
    {
        return (new IsNotEmpty())($string);
    }

    public static function startsWith(string $string, string $start): bool
    {
        return (new StartsWith($start))($string);
    }
}
