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
use Vivarium\Comparator\Comparator;

/**
 * @template T
 * @template-extends CommonQueue<T>
 */
final class PriorityQueue extends CommonQueue
{
    /** @phpstan-var ArraySequence<T>  */
    private ArraySequence $elements;

    /** @phpstan-var Comparator<T>  */
    private Comparator $comparator;

    /**
     * @param mixed ...$elements
     *
     * @phpstan-param Comparator<T> $comparator
     * @phpstan-param T ...$elements
     */
    public function __construct(Comparator $comparator, ...$elements)
    {
        $this->comparator = $comparator;
        $this->elements   = new ArraySequence(...$elements);

        $this->elements->sort($this->comparator);
    }

    /**
     * @template T0
     * @phpstan-param Comparator<T0> $comparator
     * @phpstan-param T0[] $elements
     * @phpstan-return PriorityQueue<T0>
     */
    public static function fromArray(Comparator $comparator, array $elements) : PriorityQueue
    {
        return new PriorityQueue($comparator, ...$elements);
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

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function enqueue($element) : void
    {
        $this->elements->add($element);
        $this->elements->sort($this->comparator);
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
        return $this->elements->getAtIndex(0);
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
     * @param mixed $element
     *
     * @psalm-param T $element
     */
    public function contains($element) : bool
    {
        return $this->elements->contains($element);
    }

    public function count() : int
    {
        return $this->elements->count();
    }

    public function clear() : void
    {
        $this->elements->clear();
    }
}
