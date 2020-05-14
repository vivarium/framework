<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Set;

use Vivarium\Collection\Collection;

/**
 * @template T
 * @template-extends Collection<T>
 */
interface Set extends Collection
{
    /**
     * @phpstan-param Set<T> $set
     * @phpstan-return Set<T>
     */
    public function union(Set $set) : Set;

    /**
     * @phpstan-param Set<T> $set
     * @phpstan-return Set<T>
     */
    public function intersection(Set $set) : Set;

    /**
     * @phpstan-param Set<T> $set
     * @phpstan-return Set<T>
     */
    public function difference(Set $set) : Set;

    /**
     * @phpstan-param Set<T> $set
     */
    public function isSubsetOf(Set $set) : bool;
}
