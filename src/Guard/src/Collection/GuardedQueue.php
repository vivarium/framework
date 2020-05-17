<?php

/**
 *  This file is part of Vivarium
 *  SPDX-License-Identifier: MIT
 *  Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Guard\Collection;

use Vivarium\Collection\Queue\Queue;
use Vivarium\Type\Type;

/**
 * @template T
 * @template-extends GuardedCollection<T>
 * @template-implements Queue<T>
 */
final class GuardedQueue extends GuardedCollection implements Queue
{
    /** @phpstan-var Queue<T>  */
    private Queue $queue;

    public function __construct(Type $type, Queue $queue)
    {
        parent::__construct($type, $queue);

        $this->queue = $queue;
    }

    /**
     * @param mixed $element
     *
     * @phpstan-param T $element
     */
    public function enqueue($element) : void
    {
        $this->queue->enqueue($element);
    }

    /**
     * @return mixed
     *
     * @phpstan-return T
     */
    public function dequeue()
    {
        return $this->queue->dequeue();
    }

    /**
     * @return mixed
     *
     * @phpstan-param T
     */
    public function peek()
    {
        return $this->queue->peek();
    }
}
