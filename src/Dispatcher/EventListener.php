<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Dispatcher;

/** @template T as Event */
interface EventListener
{
    /**
     * @param T $event
     *
     * @return T
     */
    public function handle($event);
}
