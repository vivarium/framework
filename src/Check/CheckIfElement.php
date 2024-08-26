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

/**
 * @method static bool isEqualsTo(mixed $first, mixed $second)
 * @method static bool isOneOf(mixed $element, array $elements)
 * @method static bool isSameOf(mixed $element, array $elements)
 */
final class CheckIfElement
{
    private static Check|null $check = null;

    public static function __callStatic($name, $arguments)
    {
        if (static::$check === null) {
            static::$check = Check::comparison();
        }

        return static::$check->$name(...$arguments);
    }
}
