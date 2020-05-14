<?php

/**
 *  This file is part of Vivarium
 *  SPDX-License-Identifier: MIT
 *  Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Guard\Collection;

use Vivarium\Collection\Queue\Queue;

final class GuardedQueue extends GuardedCollection implements Queue
{
    public function enqueue($element) : void
    {
        // TODO: Implement enqueue() method.
    }

    public function dequeue() : void
    {
        // TODO: Implement dequeue() method.
    }

    public function peek() : void
    {
        // TODO: Implement peek() method.
    }
}
