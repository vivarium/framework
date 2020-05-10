<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Queue;

use DomainException;
use Iterator;
use Vivarium\Collection\Sequence\ArraySequence;

/**
 * @template T
 * @template-extends CommonQueue<T>
 */
final class ArrayQueue extends CommonQueue
{
    /** @phpstan-var ArraySequence<T>  */
    private ArraySequence $elements;

    /**
     * @param mixed ...$elements
     *
     * @phpstan-param T ...$elements
     */
    public function __construct(...$elements)
    {
        $this->elements = new ArraySequence(...$elements);
    }

    /**
     * @template T0
     *
     * @phpstan-param T0[] $elements
     *
     * @phpstan-return ArrayQueue<T0>
     */
    public static function fromArray(array $elements) : ArrayQueue
    {
        return new ArrayQueue(...$elements);
    }

    public function clear() : void
    {
        $this->elements->clear();
    }

    /**
     * @return mixed[]
     *
     * @phpstan-return T[]
     */
    public function toArray() : array
    {
        return $this->elements->toArray();
    }

    /**
     * @return Iterator<mixed>
     *
     * @phpstan-return Iterator<T>
     */
    public function getIterator() : Iterator
    {
        return $this->elements->getIterator();
    }

    public function count() : int
    {
        return $this->elements->count();
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function enqueue($element) : void
    {
        $this->elements->add($element);
    }

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function dequeue()
    {
        if ($this->isEmpty()) {
            throw new DomainException('Cannot dequeue from an empty queue.');
        }

        $element = $this->peek();
        $this->elements->removeAtIndex(0);

        return $element;
    }

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            throw new DomainException('Cannot peek from an empty queue.');
        }

        return $this->elements->getAtIndex(0);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function contains($element) : bool
    {
        return $this->elements->contains($element);
    }
}
