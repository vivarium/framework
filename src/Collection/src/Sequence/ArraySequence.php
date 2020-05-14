<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Sequence;

use ArrayIterator;
use Iterator;
use Vivarium\Assertion\Numeric\IsInClosedRange;
use Vivarium\Assertion\Numeric\IsInHalfOpenRightRange;
use Vivarium\Comparator\Comparator;
use Vivarium\Equality\Equal;
use function array_values;
use function count;
use function max;
use function usort;

/**
 * @template T
 * @template-implements Sequence<T>
 */
final class ArraySequence implements Sequence
{
    /**
     * @var mixed[]
     * @phpstan-var T[]
     */
    private array $elements;

    /**
     * @param mixed ...$elements
     *
     * @phpstan-param T ...$elements
     */
    public function __construct(...$elements)
    {
        $this->elements = $elements;
    }

    /**
     * @template T0
     * @phpstan-param T0[] $elements
     * @phpstan-return Sequence<T0>
     */
    public static function fromArray(array $elements) : Sequence
    {
        return new ArraySequence(...$elements);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function add($element) : void
    {
        $this->elements[] = $element;
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function remove($element) : void
    {
        $index = $this->search($element);

        unset($this->elements[$index]);

        $this->elements = array_values($this->elements);
    }

    public function clear() : void
    {
        $this->elements = [];
    }

    /**
     * @return mixed[]
     *
     * @phpstan-return T[]
     */
    public function toArray() : array
    {
        return array_values($this->elements);
    }

    public function count() : int
    {
        return count($this->elements);
    }

    /**
     * @return Iterator<mixed>
     *
     * @phpstan-return Iterator<T>
     */
    public function getIterator() : Iterator
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function getAtIndex(int $index)
    {
        $this->checkBounds($index);

        return $this->elements[$index];
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function setAtIndex(int $index, $element) : void
    {
        (new IsInClosedRange(0, $this->count()))
            ->assert($index);

        $this->elements[$index] = $element;
    }

    public function removeAtIndex(int $index) : void
    {
        $this->checkBounds($index);

        unset($this->elements[$index]);
        $this->elements = array_values($this->elements);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function search($element) : int
    {
        for ($i=0; $i<$this->count(); $i++) {
            $current = $this->getAtIndex($i);
            if (Equal::areEquals($element, $current)) {
                return $i;
            }
        }

        return -1;
    }

    /**
     * @phpstan-param Comparator<T> $comparator
     */
    public function sort(Comparator $comparator) : void
    {
        usort($this->elements, $comparator);
    }

    /**
     * @param mixed $element
     *
     * @phpdstan-param T $element
     */
    public function contains($element) : bool
    {
        return $this->search($element) >= 0;
    }

    public function isEmpty() : bool
    {
        return $this->count() === 0;
    }

    private function checkBounds(int $index) : void
    {
        (new IsInHalfOpenRightRange(0, max(1, $this->count())))
            ->assert($index);
    }
}
