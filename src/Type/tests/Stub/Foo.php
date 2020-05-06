<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type\Test\Stub;

use stdClass;
use Vivarium\Type\Clazz;
use Vivarium\Type\Native;
use Vivarium\Type\Tuple;
use Vivarium\Type\Typed;

final class Foo implements Typed
{
    public function getTuple() : Tuple
    {
        return new Tuple(
            Native::integer(),
            Native::string(),
            new Clazz(stdClass::class)
        );
    }
}
