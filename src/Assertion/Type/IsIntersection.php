<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2023 Luca Cantoreggi
 *
 */

declare(strict_types=1);

namespace Vivarium\Assertion\Type;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\Var\IsString;

use function array_keys;
use function count;
use function explode;
use function sprintf;

/** @template-implements Assertion<non-empty-string> */
final class IsIntersection implements Assertion
{
    /** @psalm-assert non-empty-string $value */
    public function assert(mixed $value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected string to be intersection. Got %s.',
                (new TypeToString())($value),
            );

            throw new AssertionFailed($message);
        }
    }

    /**
     * @psalm-assert string $value
     * @psalm-assert-if-true non-empty-string $value
     */
    public function __invoke(mixed $value): bool
    {
        (new IsString())
            ->assert($value);

        $types = explode('&', $value);

        if (count($types) <= 1) {
            return false;
        }

        foreach ($types as $type) {
            if (! (new IsClassOrInterface())($type)) {
                return false;
            }

            if (count(array_keys($types, $type, true)) > 1) {
                return false;
            }
        }

        return true;
    }
}
