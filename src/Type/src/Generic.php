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

    /**
     * @param mixed $value
     */
    public function accept($value) : bool
    {
        if (! $this->class->accept($value)) {
            return false;
        }

        if (! $value instanceof Typed) {
            return false;
        }

        return $this->tuple->accept($value->getTuple());
    }
}
