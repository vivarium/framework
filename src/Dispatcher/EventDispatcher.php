<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Dispatcher;

interface EventDispatcher
{
    /**
     * @param T $event
     *
     * @return T
     *
     * @template T as Event
     */
    public function dispatch(Event $event);
}
