<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Assertion\Stub;

final class StubClassExtension extends StubClass
{
    public function __toString(): string
    {
        return 'StubClassExtension';
    }

    public function __invoke(): int
    {
        return 42;
    }
}
