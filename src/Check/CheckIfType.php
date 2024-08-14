<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

use Vivarium\Assertion\Type\ImplementsInterface;
use Vivarium\Assertion\Type\IsAssignableTo;
use Vivarium\Assertion\Type\IsAssignableToClass;
use Vivarium\Assertion\Type\IsAssignableToIntersection;
use Vivarium\Assertion\Type\IsAssignableToPrimitive;
use Vivarium\Assertion\Type\IsAssignableToUnion;
use Vivarium\Assertion\Type\IsSubclassOf;
use Vivarium\Assertion\Type\IsBasicType;
use Vivarium\Assertion\Type\IsClass;
use Vivarium\Assertion\Type\IsClassOrInterface;
use Vivarium\Assertion\Type\IsInterface;
use Vivarium\Assertion\Type\IsIntersection;
use Vivarium\Assertion\Type\IsNamespace;
use Vivarium\Assertion\Type\IsPrimitive;
use Vivarium\Assertion\Type\IsType;
use Vivarium\Assertion\Type\IsUnion;

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
    
    /** @psalm-assert-if-true class-string $string */
    public static function isInterface(string $string): bool
    {
        return (new IsInterface())($string);
    }

    public static function isIntersection(string $string): bool
    {
        return (new IsIntersection())($string);
    }

    public static function isNamespace(string $string): bool
    {
        return (new IsNamespace())($string);
    }

    public static function isPrimitive(string $string): bool
    {
        return (new IsPrimitive())($string);
    }

    /**
     * @param class-string $class
     * @param class-string $subclass
     */
    public static function isSubclassOf($class, $subclass): bool
    {
        return (new IsSubclassOf($subclass))($class);
    }

    public static function isType(string $string): bool
    {
        return (new IsType())($string);
    }

    public static function isUnion(string $string): bool
    {
        return (new IsUnion())($string);
    }
}
