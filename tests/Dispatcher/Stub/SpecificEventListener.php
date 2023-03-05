<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Test\Dispatcher\Stub;

use Vivarium\Dispatcher\EventListener;
use Vivarium\Equality\Equality;
use Vivarium\Equality\EqualsBuilder;
use Vivarium\Equality\HashBuilder;

use function get_class;

/**
 * @template T as SpecificEvent
 * @template-implements EventListener<T>
 */
final class SpecificEventListener implements EventListener, Equality
{
    /** @param T $event */
    public function handle($event): SpecificEvent
    {
        return $event;
    }

    public function equals(object $object): bool
    {
        return (new EqualsBuilder())
            ->append(self::class, get_class($object))
            ->isEquals();
    }

    public function hash(): string
    {
        return (new HashBuilder())
            ->append(self::class)
            ->getHashCode();
    }
}
