<?php

/**
 *  This file is part of Vivarium
 *  SPDX-License-Identifier: MIT
 *  Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Guard\Collection;

use Vivarium\Collection\Collection;

/**
 * @template T
 * @template-implements Collection<T>
 */
abstract class GuardedCollection implements Collection
{
    /** @phpstan-var Collection<T> */
    private Collection $collection;

    /**
     * @phpstan-param Collection<T> $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @phpstan-param T $element
     */
    public function add($element): void
     {
         // TODO: Implement add() method.
     }

    /**
     * @phpstan-param T $element
     */
     public function remove($element): void
     {
         // TODO: Implement remove() method.
     }

    /**
     * @phpstan-param T $element
     */
     public function contains($element): bool
     {
         // TODO: Implement contains() method.
     }

     public function isEmpty(): bool
     {
         // TODO: Implement isEmpty() method.
     }

     public function clear(): void
     {
         // TODO: Implement clear() method.
     }

    /**
     * @phpstan-return T[]
     */
     public function toArray(): array
     {
         // TODO: Implement toArray() method.
     }

     public function getIterator()
     {
         // TODO: Implement getIterator() method.
     }

     public function count()
     {
         // TODO: Implement count() method.
     }
 }

