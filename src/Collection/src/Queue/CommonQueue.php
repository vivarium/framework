<?php

/**
 *  This file is part of Vivarium
 *  SPDX-License-Identifier: MIT
 *  Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Collection\Queue;

use Vivarium\Equality\Equal;

/**
 * @template T
 * @phpstan-implements Queue<T>
 */
abstract class CommonQueue implements Queue
{
    /**
     * @phpstan-param T $element
     */
    public function add($element) : void
    {
        $this->enqueue($element);
    }

    /**
     * @phpstan-param T $element
     */
    public function remove($element) : void
    {
        if (! $this->contains($element)) {
            return;
        }

        while (! Equal::areEquals($this->peek(), $element)) {
            $this->dequeue();
        }

        $this->dequeue();
    }

    public function isEmpty() : bool
    {
        return $this->count() === 0;
    }
}
