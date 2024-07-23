<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

use Vivarium\Assertion\Numeric\IsGreaterOrEqualThan;
use Vivarium\Assertion\Numeric\IsGreaterThan;
use Vivarium\Assertion\Numeric\IsInClosedRange;
use Vivarium\Assertion\Numeric\IsInHalfOpenRightRange;
use Vivarium\Assertion\Numeric\IsInOpenRange;
use Vivarium\Assertion\Numeric\IsLessOrEqualThan;
use Vivarium\Assertion\Numeric\IsLessThan;
use Vivarium\Assertion\Numeric\IsOutOfClosedRange;
use Vivarium\Assertion\Numeric\IsOutOfOpenRange;

final class CheckIfNumber
{
    public static function isGreaterOrEqualThan(int|float $number, int|float $target): bool
    {
        return (new IsGreaterOrEqualThan($target))($number);
    }

    public static function isGreaterThan(int|float $number, int|float $target): bool
    {
        return (new IsGreaterThan($target))($number);
    }

    public static function isInClosedRange(int|float $number, int|float $min, int|float $max): bool
    {
        return (new IsInClosedRange($min, $max))($number);
    }

    public static function isInHalfOpenRightRange(int|float $number, int|float $min, int|float $max): bool
    {
        return (new IsInHalfOpenRightRange($min, $max))($number);
    }

    public static function isInOpenRange(int|float $number, int|float $min, int|float $max): bool
    {
        return (new IsInOpenRange($min, $max))($number);
    }

    public static function isLessOrEqualThan(int|float $number, int|float $target): bool
    {
        return (new IsLessOrEqualThan($target))($number);
    }

    public static function isLessThan(int|float $number, int|float $target): bool
    {
        return (new IsLessThan($target))($number);
    }

    public static function isOutOfClosedRange(int|float $number, int|float $min, int|float $max): bool
    {
        return (new IsOutOfClosedRange($min, $max))($number);
    }

    public static function isOutOfOpenRange(int|float $number, int|float $min, int|float $max): bool
    {
        return (new IsOutOfOpenRange($min, $max))($number);
    }
}
