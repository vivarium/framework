<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Set;

use Vivarium\Type\Assertion\IsAssignaleTuple;

/**
 * @template T
 * @template-implements Set<T>
 */
abstract class CommonSet implements Set
{
    /**
     * @phpstan-param Set<T> $set
     *
     * @phpstan-return Set<T>
     */
    public function union(Set $set) : Set
    {
        $union = $this->emptySet();

        foreach ($this as $value) {
            $union->add($value);
        }

        foreach ($set as $value) {
            $union->add($value);
        }

        return $union;
    }

    /**
     * @phpstan-param Set<T> $set
     *
     * @phpstan-return Set<T>
     */
    public function intersection(Set $set) : Set
    {
        $intersection = $this->emptySet();
        foreach ($this as $element) {
            if (! $set->contains($element)) {
                continue;
            }

            $intersection->add($element);
        }

        return $intersection;
    }

    /**
     * @phpstan-param Set<T> $set
     *
     * @phpstan-return Set<T>
     */
    public function difference(Set $set) : Set
    {
        $difference = $this->emptySet();
        foreach ($this as $element) {
            if ($set->contains($element)) {
                continue;
            }

            $difference->add($element);
        }

        return $difference;
    }

    /**
     * @phpstan-param Set<T> $set
     */
    public function isSubsetOf(Set $set) : bool
    {
        foreach ($this as $element) {
            if (! $set->contains($element)) {
                return false;
            }
        }

        return true;
    }

    public function isEmpty() : bool
    {
        return $this->count() === 0;
    }

    /**
     * @phpstan-return Set<T>
     */
    abstract protected function emptySet() : Set;
}
