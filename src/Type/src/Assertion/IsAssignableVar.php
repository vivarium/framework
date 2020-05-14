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
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Type\Type;
use function sprintf;

final class IsAssignableVar implements Assertion
{
    private Type $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $value
     */
    public function assert($value, string $message = '') : void
    {
        if (! ($this)($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected Var to be assignable Got %s.',
                (new TypeToString())($value)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     */
    public function __invoke($value) : bool
    {
        return $this->type->acceptVar($value);
    }
}
