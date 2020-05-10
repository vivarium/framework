<?php

/**
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2020 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Type\Assertion;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Hierarchy\IsAssignableTo;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Type\Type;

final class IsAssignableType implements Assertion
{
    private Type $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function assert($value, string $message = ''): void
    {
        if (! ($this)($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected Type to be assignable Got %s.',
                (new TypeToString())($value)
            );

            throw new InvalidArgumentException($message);
        }
    }

    public function __invoke($value): bool
    {
        (new IsAssignableTo(Type::class))->assert($value);

        return $this->type->accept($value);
    }
}

