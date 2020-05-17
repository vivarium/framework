<?php

/**
 *  This file is part of Vivarium
 *  SPDX-License-Identifier: MIT
 *  Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Dispatcher;

/**
 * @template T
 */
interface EventListener
{
    /**
     * @param mixed $event
     *
     * @phpstan-param T $event
     */
    public function handle($event) : void;
}
