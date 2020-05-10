<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Map;

use ArrayIterator;
use Iterator;
use Vivarium\Collection\Pair\Pair;

/**
 * @template K
 * @template V
 * @template-implements Iterator<K, V>
 */
final class MapIterator implements Iterator
{
    /**
     * @var Iterator<Pair>
     * @phpstan-var Iterator<Pair<K, V>>
     */
    private Iterator $iterator;

    /**
     * @param Pair[] $pairs
     *
     * @phpstan-param Pair<K, V>[] $pairs
     */
    public function __construct(array $pairs)
    {
        $this->iterator = new ArrayIterator($pairs);
    }

    /**
     * @return mixed
     *
     * @phpstan-return V
     */
    public function current()
    {
        return $this->iterator
            ->current()
            ->getValue();
    }

    public function next() : void
    {
        $this->iterator->next();
    }

    /**
     * @return mixed
     *
     * @phpstan-return K
     */
    public function key()
    {
        return $this->iterator
            ->current()
            ->getKey();
    }

    public function valid() : bool
    {
        return $this->iterator->valid();
    }

    public function rewind() : void
    {
        $this->iterator->rewind();
    }
}
