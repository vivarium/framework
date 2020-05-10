<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Sequence;

use Vivarium\Collection\Collection;
use Vivarium\Comparator\Comparator;

/**
 * @template T
 * @template-extends Collection<T>
 */
interface Sequence extends Collection
{
    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function setAtIndex(int $index, $element) : void;

    public function removeAtIndex(int $index) : void;

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function getAtIndex(int $index);

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function search($element) : int;

    /**
     * @phpstan-param Comparator<T> $comparator
     */
    public function sort(Comparator $comparator) : void;
}
