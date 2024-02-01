<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2024 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Test\Equality\Stub;

use Vivarium\Equality\Equality;
use Vivarium\Equality\HashBuilder;

final class EqualityStub implements Equality
{

    public function equals(object $object): bool 
    {
        return $object instanceof EqualityStub;
    }

    public function hash(): string 
    { 
        return (new HashBuilder)
            ->append(42)
            ->getHashCode();
    }
}
