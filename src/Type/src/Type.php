<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type;

interface Type
{
    public function accept(Type $type) : bool;

    /**
     * @param mixed $value
     */
    public function acceptVar($value) : bool;
}
