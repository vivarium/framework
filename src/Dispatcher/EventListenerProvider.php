<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Dispatcher;

use Vivarium\Collection\Collection;

interface EventListenerProvider
{
    /**
     * @param class-string<Event> $event
     *
     * @return Collection<ListenerAndPriority<Event>>
     */
    public function provide(string $event): Collection;
}
