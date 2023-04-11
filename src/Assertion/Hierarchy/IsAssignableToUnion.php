<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2023 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Hierarchy;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsBasicType;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\String\IsIntersection;

use Vivarium\Assertion\String\IsUnion;
use function explode;
use function sprintf;

/** @template-implements Assertion<string> */
final class IsAssignableToUnion implements Assertion
{
    public function __construct(private string $union)
    {
        (new IsUnion())
            ->assert($union);
    }

    public function assert(mixed $value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected type to be assignable to union %2$s Got %1$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->union),
            );

            throw new AssertionFailed($message);
        }
    }

    public function __invoke(mixed $value): bool
    {
        (new IsBasicType())
            ->assert($value);

        foreach (explode('|', $this->union) as $type) {
            if ((new IsAssignableTo($type))($value)) {
                return true;
            }
        }

        return false;
    }
}
