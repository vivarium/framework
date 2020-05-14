<?php

/**
 *  This file is part of Vivarium
 *  SPDX-License-Identifier: MIT
 *  Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Guard\Collection;

use Exception;
use Traversable;
use Vivarium\Collection\Collection;
use Vivarium\Type\Assertion\IsAssignableVar;
use Vivarium\Type\Tuple;
use Vivarium\Type\Type;
use Vivarium\Type\Typed;

/**
 * @template T
 * @template-implements Collection<T>
 */
abstract class GuardedCollection implements Collection, Typed
{
    /** @phpstan-var Collection<T> */
    private Collection $collection;

    private Type $type;

    /**
     * @phpstan-param Collection<T> $collection
     */
    public function __construct(Type $type, Collection $collection)
    {
        $this->type = $type;

        $this->collection = $collection;
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function add($element) : void
    {
        $this->checkType($element);

        $this->collection->add($element);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function remove($element) : void
    {
        $this->checkType($element);

        $this->collection->remove($element);
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function contains($element) : bool
    {
        $this->checkType($element);

        return $this->collection->contains($element);
    }

    public function isEmpty() : bool
    {
        return $this->collection->isEmpty();
    }

    public function clear() : void
    {
        $this->collection->clear();
    }

    /**
     * @return mixed[]
     *
     * @phpstan-return T[]
     */
    public function toArray() : array
    {
        return $this->collection->toArray();
    }

    /**
     * @return Traversable<mixed>
     *
     * @phpstan-return Traversable<T>
     * @throws Exception
     */
    public function getIterator() : Traversable
    {
        return $this->collection->getIterator();
    }

    public function count() : void
    {
        $this->collection->count();
    }

    public function getTuple() : Tuple
    {
        return new Tuple($this->type);
    }

    /**
     * @param mixed $var
     */
    protected function checkType($var) : void
    {
        (new IsAssignableVar($this->type))
            ->assert($var);
    }
}
