<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

use Vivarium\Assertion\Object\HasMethod;
use Vivarium\Assertion\Object\IsInstanceOf;

final class CheckIfObject
{
    public static function hasMethod(object|string $object, string $method): bool
    {
        return (new HasMethod($method))($object);
    }

    /**
     * @param class-string<T> $class
     *
     * @template T of object
     */
    public static function isInstanceOf(object $object, string $class): bool
    {
        return (new IsInstanceOf($class))($object);
    }
}
