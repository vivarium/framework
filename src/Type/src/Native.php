<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type;

use Vivarium\Assertion\Type\IsFloat;
use Vivarium\Assertion\Type\IsInteger;
use Vivarium\Assertion\Type\IsString;

final class Native
{
    public static function integer() : Type
    {
        return new class implements Type
        {
            public function accept(Type $type) : bool
            {
                return $type instanceof self;
            }

            /**
             * @param mixed $value
             */
            public function acceptVar($value) : bool
            {
                return (new IsInteger())($value);
            }
        };
    }

    public static function float() : Type
    {
        return new class implements Type
        {
            public function accept(Type $type) : bool
            {
                return $type instanceof self;
            }

            /**
             * @param mixed $value
             */
            public function acceptVar($value) : bool
            {
                return (new IsFloat())($value);
            }
        };
    }

    public static function string() : Type
    {
        return new class implements Type
        {
            public function accept(Type $type) : bool
            {
                return $type instanceof self;
            }

            /**
             * @param mixed $value
             */
            public function acceptVar($value) : bool
            {
                return (new IsString())($value);
            }
        };
    }

    public static function mixed() : Type
    {
        return new class implements Type
        {
            public function accept(Type $type) : bool
            {
                return true;
            }

            /**
             * @param mixed $value
             */
            public function acceptVar($value) : bool
            {
                return true;
            }
        };
    }
}
