<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

use Vivarium\Assertion\Hierarchy\ImplementsInterface;
use Vivarium\Assertion\Hierarchy\IsAssignableTo;
use Vivarium\Assertion\Hierarchy\IsAssignableToClass;
use Vivarium\Assertion\Hierarchy\IsAssignableToIntersection;
use Vivarium\Assertion\Hierarchy\IsAssignableToPrimitive;
use Vivarium\Assertion\Hierarchy\IsAssignableToUnion;
use Vivarium\Assertion\Hierarchy\IsSubclassOf;

final class CheckIfType
{
    /**
     * @param class-string $class
     * @param class-string $interface
     */
    public static function implementsInterface(string $class, string $interface): bool
    {
        return (new ImplementsInterface($interface))($class);
    }

    public static function isAssignableTo(string $type, string $target): bool
    {
        return (new IsAssignableTo($target))($type);
    }

    /**
     * @param class-string $class
     * @param class-string $target
     */
    public static function isAssignableToClass(string $class, string $target): bool
    {
        return (new IsAssignableToClass($target))($class);
    }

    public static function isAssignableToIntersection(string $type, string $intersection): bool
    {
        return (new IsAssignableToIntersection($intersection))($type);
    }

    public static function isAssignableToPrimitive(string $type, string $primitive): bool
    {
        return (new IsAssignableToPrimitive($primitive))($type);
    }

    public static function isAssignableToUnion(string $type, string $union): bool
    {
        return (new IsAssignableToUnion($union))($type);
    }

    /**
     * @param class-string $class
     * @param class-string $subclass
     */
    public static function isSubclassOf($class, $subclass): bool
    {
        return (new IsSubclassOf($subclass))($class);
    }
}
