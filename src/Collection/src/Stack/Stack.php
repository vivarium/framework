<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Stack;

use Vivarium\Collection\Collection;

/**
 * @template T
 * @template-extends Collection<T>
 */
interface Stack extends Collection
{
    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function push($element) : void;

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function pop();

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function peek();
}
