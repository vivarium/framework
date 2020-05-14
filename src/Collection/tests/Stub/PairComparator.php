<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Test\Stub;

use Vivarium\Collection\Pair\Pair;
use Vivarium\Comparator\Comparator;

/**
 * @template K
 * @template V
 * @template-implements Comparator<Pair<K, V>>
 */
final class PairComparator implements Comparator
{
    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @phpstan-param Pair<K, V> $first
     * @phpstan-param Pair<K, V> $second
     */
    public function compare($first, $second) : int
    {
        if ($first->getKey() === $second->getKey()) {
            return 0;
        }

        if ($first->getKey() < $second->getKey()) {
            return -1;
        }

        return 1;
    }

    /**
     * @param mixed $first
     * @param mixed $second
     *
     * @phpstan-param Pair<K, V> $first
     * @phpstan-param Pair<K, V> $second
     */
    public function __invoke($first, $second) : int
    {
        return $this->compare($first, $second);
    }
}
