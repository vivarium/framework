<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type;

use Vivarium\Assertion\Conditional\Either;
use Vivarium\Assertion\Hierarchy\IsAssignableTo;
use Vivarium\Assertion\Object\IsInstanceOf;
use Vivarium\Assertion\String\IsClass;
use Vivarium\Assertion\String\IsInterface;
use Vivarium\Assertion\Type\IsObject;

final class Clazz implements Type
{
    private string $class;

    public function __construct(string $class)
    {
        (new Either(
            new IsClass(),
            new IsInterface()
        ))->assert($class);

        $this->class = $class;
    }

    public function accept(Type $type) : bool
    {
        if (! $type instanceof Clazz) {
            return false;
        }

        return (new IsAssignableTo($this->class))($type->class);
    }

    /**
     * @param mixed $value
     */
    public function acceptVar($value) : bool
    {
        if (! (new IsObject())($value)) {
            return false;
        }

        return (new IsInstanceOf($this->class))($value);
    }
}
