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
    /**
     * @param mixed $value
     */
    public function accept($value) : bool;
}
