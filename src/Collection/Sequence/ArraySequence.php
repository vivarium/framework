<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Sequence;

use ArrayIterator;
use Iterator;
use OutOfBoundsException;
use Vivarium\Collection\Util\Vector;
use Vivarium\Comparator\Comparator;
use Vivarium\Equality\Equal;
use Vivarium\Equality\EqualsBuilder;
use Vivarium\Equality\HashBuilder;

use function array_values;
use function count;
use function sprintf;
use function usort;

/**
 * @template T
 * @template-implements Sequence<T>
 */
final class ArraySequence implements Sequence
{
    /** @var array<int, T> */
    private array $elements;

    /**
     * @param T ...$elements
     *
     * @no-named-arguments
     */
    public function __construct(...$elements)
    {
        $this->elements = $elements;
    }

    /**
     * @param array<T0> $elements
     *
     * @return ArraySequence<T0>
     *
     * @template T0
     */
    public static function fromArray(array $elements): ArraySequence
    {
        return new ArraySequence(...array_values($elements));
    }

    /**
     * @param T $element
     *
     * @return ArraySequence<T>
     */
    public function add($element): ArraySequence
    {
        $list             = clone $this;
        $list->elements[] = $element;

        return $list;
    }

    /**
     * @param T $element
     *
     * @return ArraySequence<T>
     */
    public function remove($element): ArraySequence
    {
        $list  = clone $this;
        $index = $this->search($element);

        unset($list->elements[$index]);

        $list->elements = array_values($list->elements);

        return $list;
    }

    /** @return ArraySequence<T> */
    public function clear(): ArraySequence
    {
        return new ArraySequence();
    }

    /** @return array<int, T> */
    public function toArray(): array
    {
        return $this->elements;
    }

    public function count(): int
    {
        return count($this->elements);
    }

    /** @return Iterator<int, T> */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->elements);
    }

    /** @return T */
    public function getAtIndex(int $index)
    {
        /** @psalm-suppress UnusedMethodCall */
        $this->checkBounds($index);

        return $this->elements[$index];
    }

    /**
     * @param T $element
     *
     * @return ArraySequence<T>
     */
    public function setAtIndex(int $index, $element): ArraySequence
    {
        /** @psalm-suppress UnusedMethodCall */
        $this->checkBounds($index);

        $list                   = clone $this;
        $list->elements[$index] = $element;

        return $list;
    }

    /** @return ArraySequence<T> */
    public function removeAtIndex(int $index): ArraySequence
    {
        /** @psalm-suppress UnusedMethodCall */
        $this->checkBounds($index);

        $list = clone $this;
        unset($list->elements[$index]);
        $list->elements = array_values($list->elements);

        return $list;
    }

    /** @param T $element */
    public function search($element): int
    {
        return Vector::linearSearch(
            $this->elements,
            $element,
            /**
             * @param T $current
             * @param T $element
             */
            static function ($current, $element): bool {
                return Equal::areEquals($current, $element);
            },
        );
    }

    /**
     * @param Comparator<T> $comparator
     *
     * @return ArraySequence<T>
     */
    public function sort(Comparator $comparator): ArraySequence
    {
        $list = clone $this;

        usort($list->elements, $comparator);

        return $list;
    }

    /** @param T $element */
    public function contains($element): bool
    {
        return $this->search($element) >= 0;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function equals(object $object): bool
    {
        if (! $object instanceof ArraySequence) {
            return false;
        }

        if ($object === $this) {
            return true;
        }

        return (new EqualsBuilder())
            ->append($this->elements, $object->elements)
            ->isEquals();
    }

    public function hash(): string
    {
        return (new HashBuilder())
            ->append($this->elements)
            ->getHashCode();
    }

    private function checkBounds(int $index): void
    {
        if ($index < 0 || $index >= $this->count()) {
            $message = sprintf('Index out of bound. Count: %s, Index: %s', $this->count(), $index);

            throw new OutOfBoundsException($message);
        }
    }
}
