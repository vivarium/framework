<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Comparator;

/** @template T */
interface Comparator
{
    /**
     * @param T $first
     * @param T $second
     */
    public function compare($first, $second): int;

    /**
     * @param T $first
     * @param T $second
     */
    public function __invoke($first, $second): int;
}
