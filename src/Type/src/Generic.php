<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type;

final class Generic implements Type
{
    private Clazz $class;

    private Tuple $tuple;

    public function __construct(Clazz $class, Tuple $tuple)
    {
        $this->class = $class;
        $this->tuple = $tuple;
    }

    public function accept(Type $type) : bool
    {
        if (! $type instanceof Generic) {
            return false;
        }

        return $this->class->accept($type->class) &&
               $this->tuple->accept($type->tuple);
    }

    /**
     * @param mixed $value
     */
    public function acceptVar($value) : bool
    {
        if (! $this->class->acceptVar($value)) {
            return false;
        }

        if (! $value instanceof Typed) {
            return false;
        }

        return $this->tuple->accept($value->getTuple());
    }
}
