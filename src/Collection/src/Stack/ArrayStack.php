<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Stack;

use ArrayIterator;
use DomainException;
use Iterator;
use Vivarium\Collection\Sequence\ArraySequence;
use Vivarium\Collection\Sequence\Sequence;
use function array_reverse;
use function count;

/**
 * @template T
 * @template-implements Stack<T>
 */
final class ArrayStack implements Stack
{
    /** @phpstan-var Sequence<T> */
    private Sequence $elements;

    /**
     * @param mixed ...$elements
     *
     * @phpstan-param T ...$elements
     */
    public function __construct(...$elements)
    {
        $this->elements = ArraySequence::fromArray($elements);
    }

    /**
     * @template T0
     * @phpstan-param T0[] $elements
     * @phpstan-return ArrayStack<T0>
     */
    public static function fromArray(array $elements) : ArrayStack
    {
        return new ArrayStack(...$elements);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function push($element) : void
    {
        $this->elements->add($element);
    }

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new DomainException('Cannot pop from an empty stack.');
        }

        $element = $this->peek();
        $this->elements->removeAtIndex($this->count() - 1);

        return $element;
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function add($element) : void
    {
        $this->push($element);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function remove($element) : void
    {
        $index = $this->count() - $this->elements->search($element);
        for ($i = 0; $i < $index; $i++) {
            $this->pop();
        }
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

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            throw new DomainException('Cannot peek from an empty stack.');
        }

        return $this->elements->getAtIndex($this->count() - 1);
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
        return array_reverse($this->elements->toArray());
    }

    /**
     * @return Iterator<mixed>
     *
     * @phpstan-return Iterator<T>
     */
    public function getIterator() : Iterator
    {
        return new ArrayIterator(
            array_reverse(
                $this->elements->toArray()
            )
        );
    }

    public function count() : int
    {
        return count($this->elements);
    }

    public function isEmpty() : bool
    {
        return $this->count() === 0;
    }
}
