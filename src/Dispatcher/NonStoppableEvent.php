<?php

declare(strict_types=1);

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

namespace Vivarium\Dispatcher;

abstract class NonStoppableEvent implements Event
{
    public function isPropagationStopped(): bool
    {
        return false;
    }
}
