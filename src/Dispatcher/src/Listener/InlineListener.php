<?php

/**
 *  This file is part of Vivarium
 *  SPDX-License-Identifier: MIT
 *  Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Dispatcher\Listener;

use Closure;
use Vivarium\Dispatcher\EventListener;

/**
 * @template T
 * @template-implements EventListener<T>
 */
final class InlineListener implements EventListener
{
    /**
     * @vphpstan-var Closure(T)
     */
    private Closure $func;

    /**
     * @phpstan-param Closure<T> $func
     */
    public function __construct(Closure $func)
    {
        $this->func = $func;
    }

    public function handle($event): void
    {
        ($this->func)($event);
    }
}
