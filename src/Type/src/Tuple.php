<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type;

use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;
use OutOfBoundsException;
use function array_merge;
use function count;
use function sprintf;

/**
 * @template-implements IteratorAggregate<Type>
 */
final class Tuple implements IteratorAggregate, Countable
{
    /** @var Type[]  */
    private array $types;

    public function __construct(Type $type, Type ...$types)
    {
        $this->types = array_merge([$type], $types);
    }

    public function count() : int
    {
        return count($this->types);
    }

    /**
     * @return Iterator<Type>
     */
    public function getIterator() : Iterator
    {
        return new ArrayIterator($this->types);
    }

    public function nth(int $index) : Type
    {
        if ($index >= $this->count()) {
            throw new OutOfBoundsException(
                sprintf('Index out of bound. Count: %s, Index: %s', $this->count(), $index)
            );
        }

        return $this->types[$index];
    }

    public function accept(Tuple $tuple) : bool
    {
        if ($this->count() !== $tuple->count()) {
            return false;
        }

        for ($i = 0; $i < $this->count(); $i++) {
            if (! $this->nth($i)->accept($tuple->nth($i))) {
                return false;
            }
        }

        return true;
    }
}
