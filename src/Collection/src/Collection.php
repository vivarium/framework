<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection;

use Countable;
use IteratorAggregate;

/**
 * @template T
 * @template-extends IteratorAggregate<int, T>
 */
interface Collection extends Countable, IteratorAggregate
{
    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function add($element) : void;

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function remove($element) : void;

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function contains($element) : bool;

    public function isEmpty() : bool;

    public function clear() : void;

    /**
     * @return mixed[]
     *
     * @phpstan-return T[]
     */
    public function toArray() : array;
}
