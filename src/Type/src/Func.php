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
use ReflectionParameter;
use ReflectionType;
use function assert;

final class Func implements Type
{
    private Tuple $tuple;

    public function __construct(Tuple $tuple)
    {
        $this->tuple = $tuple;
    }

    public function accept(Type $type) : bool
    {
        if (! $type instanceof Func) {
            return false;
        }

        return $this->tuple->accept(
            $type->tuple
        );
    }

    /**
     * @param mixed $value
     */
    public function acceptVar($value) : bool
    {
        try {
            $reflector = new ReflectionFunction($value);

            if ($this->tuple->count() !== $reflector->getNumberOfParameters()) {
                return false;
            }

            $parameters = $reflector->getParameters();
            for ($i = 0; $i < $this->tuple->count(); $i++) {
                if (! $this->tuple->nth($i)->accept(
                    $this->extractParameter($parameters[$i])
                )) {
                    return false;
                }
            }
        } catch (ReflectionException $e) {
            return false;
        }

        return true;
    }

    private function extractParameter(ReflectionParameter $parameter) : Type
    {
        if (! $parameter->hasType()) {
            return Native::mixed();
        }

        $type = $parameter->getType();
        assert($type instanceof ReflectionType);

        return new Clazz($type->getName());
    }
}
