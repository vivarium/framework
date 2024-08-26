<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Check;

/**
 * @method static bool hasMethod(object $object, string $method)
 * @method static bool hasProperty(object $object, string $property)
 * @method static bool isInstanceOf(object $object, string $class)
 */
final class CheckIfObject
{
    private static Check|null $check = null;

    public static function __callStatic($name, $arguments)
    {
        if (static::$check === null) {
            static::$check = Check::object();
        }

        return static::$check->$name(...$arguments);
    }
}
