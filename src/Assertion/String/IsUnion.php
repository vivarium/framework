<?php

/*
 * This file is part of Vivarium
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2023 Luca Cantoreggi
 */

declare(strict_types=1);

namespace Vivarium\Assertion\String;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Conditional\Each;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;

use Vivarium\Assertion\Type\IsString;
use function count;
use function explode;
use function sprintf;

final class IsUnion implements Assertion
{
    public function assert(mixed $value, string $message = ''): void
    {
        (new IsString())
            ->assert($value);

        try {
            $types = explode('|', $value);

            if (count($types) <= 1) {
                throw new AssertionFailed('Union must be composed at least by two elements.');
            }

            (new Each(
                new IsBasicType(),
            ))->assert($types);
        }
        catch (AssertionFailed $ex) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected string to be union. Got %s.',
                (new TypeToString())($value),
            );

            throw new AssertionFailed($message, $ex->getCode(), $ex);
        }
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
