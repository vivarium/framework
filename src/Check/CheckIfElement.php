<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

use Vivarium\Assertion\Comparison\IsEqualsTo;
use Vivarium\Assertion\Comparison\IsOneOf;
use Vivarium\Assertion\Comparison\IsSameOf;

final class CheckIfElement
{
    /**
     * @param T $element
     * @param T $compare
     *
     * @template T
     */
    public static function isEqualTo($element, $compare): bool
    {
        return (new IsEqualsTo($compare))($element);
    }

    /**
     * @param T $element
     * @param T ...$choices
     *
     * @template T
     */
    public static function isOneOf($element, ...$choices): bool
    {
        return (new IsOneOf(...$choices))($element);
    }

    /**
     * @param T $element
     * @param T $compare
     *
     * @template T
     */
    public static function isSameOf($element, $compare): bool
    {
        return (new IsSameOf($compare))($element);
    }
}
