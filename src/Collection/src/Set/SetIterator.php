<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Set;

use ArrayIterator;
use Iterator;
use Vivarium\Collection\Pair\Pair;

/**
 * @template T
 * @template-implements Iterator<T>
 */
class SetIterator implements Iterator
{
    /**
     * @var Iterator<mixed>
     * @phpstan-var Iterator<Pair<T, int>>
     */
    private Iterator $iterator;

    private int $index;

    /**
     * @param Pair[] $pairs
     *
     * @phpstan-param Pair<T, int>[] $pairs
     */
    public function __construct(array $pairs)
    {
        $this->iterator = new ArrayIterator($pairs);
        $this->index    = 0;
    }

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function current()
    {
        return $this->iterator
            ->current()
            ->getKey();
    }

    public function next() : void
    {
        $this->iterator->next();
        ++$this->index;
    }

    public function key() : int
    {
        return $this->index;
    }

    public function valid() : bool
    {
        return $this->iterator->valid();
    }

    public function rewind() : void
    {
        $this->iterator->rewind();
        $this->index = 0;
    }
}
