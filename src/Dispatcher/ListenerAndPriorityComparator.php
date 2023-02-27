<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Dispatcher;

use Vivarium\Comparator\Comparator;

/** @template-implements Comparator<ListenerAndPriority<Event>> */
final class ListenerAndPriorityComparator implements Comparator
{
    /**
     * @param ListenerAndPriority<Event> $first
     * @param ListenerAndPriority<Event> $second
     *
     * @psalm-mutation-free
     */
    public function compare($first, $second): int
    {
        return $second->getPriority() - $first->getPriority();
    }

    /**
     * @param ListenerAndPriority<Event> $first
     * @param ListenerAndPriority<Event> $second
     *
     * @psalm-mutation-free
     */
    public function __invoke($first, $second): int
    {
        return $this->compare($first, $second);
    }
}
