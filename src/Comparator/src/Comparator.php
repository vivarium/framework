<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator;

/**
 * @template T
 */
interface Comparator
{
    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @phpstan-param T $first
     * @phpstan-param T $second
     */
    public function compare($first, $second) : int;

    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @phpstan-param T $first
     * @phpstan-param T $second
     */
    public function __invoke($first, $second) : int;
}
