<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2021 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Hierarchy;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsClassOrInterface;
use Vivarium\Assertion\String\IsEmpty;

use function is_a;
use function sprintf;

/**
 * @template T
 * @template-implements Assertion<class-string<T>>
 */
final class IsAssignableTo implements Assertion
{
    /** @param class-string<T> $class */
    public function __construct(private string $class)
    {
        (new IsClassOrInterface())->assert($class);
    }

    public function assert(mixed $value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                     $message : 'Expected class %s to be assignable to %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->class),
            );

            throw new AssertionFailed($message);
        }
    }

    public function __invoke(mixed $value): bool
    {
        (new IsClassOrInterface())->assert($value);

        return is_a($value, $this->class, true);
    }
}
