<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Dispatcher;

use Vivarium\Equality\Equality;
use Vivarium\Equality\EqualsBuilder;
use Vivarium\Equality\HashBuilder;

/** @template T as Event */
final class ListenerAndPriority implements Equality
{
    /** @var EventListener<T> */
    private EventListener $listener;

    private int $priority;

    /** @param EventListener<T> $listener */
    public function __construct(EventListener $listener, int $priority)
    {
        $this->listener = $listener;
        $this->priority = $priority;
    }

    /** @return EventListener<T> */
    public function getEventListener(): EventListener
    {
        return $this->listener;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function equals(object $object): bool
    {
        if (! $object instanceof ListenerAndPriority) {
            return false;
        }

        if ($object === $this) {
            return true;
        }

        return (new EqualsBuilder())
            ->append($this->listener, $object->listener)
            ->append($this->priority, $object->priority)
            ->isEquals();
    }

    public function hash(): string
    {
        return (new HashBuilder())
            ->append($this->listener)
            ->append($this->priority)
            ->getHashCode();
    }
}
