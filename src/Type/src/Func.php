<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type;

use ReflectionException;
use ReflectionFunction;
use ReflectionType;

final class Func implements Type
{
    private Tuple $tuple;

    public function __construct(Tuple $tuple)
    {
        $this->tuple = $tuple;
    }

    public function accept($value) : bool
    {
        try {
            $reflector = new ReflectionFunction($value);

            if ($this->tuple->count() !== $reflector->getNumberOfParameters()) {
                return false;
            }

            $parameters = $reflector->getParameters();
            for ($i = 0; $i < $this->tuple->count(); $i++) {
                if (! $this->tuple->nth($i)->accept(
                    $parameters[$i]->getType()->getName()
                )) {
                    return false;
                }
            }
        } catch (ReflectionException $e) {
            return false;
        }

        return true;
    }
}
