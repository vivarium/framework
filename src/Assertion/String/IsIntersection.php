<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2023 Luca Cantoreggi
 *
 */

namespace Vivarium\Assertion\String;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Each;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;

/** @template-implements Assertion<string> */
final class IsIntersection implements Assertion
{
    public function assert(mixed $value, string $message = ''): void
    {
        $types = explode('&', $value);
        if (count($types) <= 1) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected string to be intersection. Got %s.',
                (new TypeToString)($value),
            );
        }

        (new Each(
            new IsType()
        ))->assert($types);
    }

    public function __invoke(mixed $value): bool
    {
        try {
            $this->assert($value);

            return true;
        } catch (AssertionFailed) {
            return false;
        }
    }
}
