<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2023 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\String;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Not;

/** @template-implements Assertion<string> */
final class IsNotEmpty implements Assertion
{
    /** @psalm-var Assertion<string>  */
    private Assertion $assertion;

    public function __construct()
    {
        $this->assertion = new Not(
            new IsEmpty(),
        );
    }

    /** @psalm-assert non-empty-string $value */
    public function assert(mixed $value, string $message = ''): void
    {
        $this->assertion->assert(
            $value,
            ! (new IsEmpty())($message) ?
                $message : 'Expected string to be not empty.',
        );
    }

    /** @psalm-assert-if-true non-empty-string $value */
    public function __invoke(mixed $value): bool
    {
        return ($this->assertion)($value);
    }
}
