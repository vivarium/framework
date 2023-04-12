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
use Vivarium\Assertion\String\IsClassOrInterface;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\String\IsIntersection;
use Vivarium\Assertion\String\IsType;
use Vivarium\Assertion\String\IsUnion;

use function sprintf;

/** @template-implements Assertion<string> */
final class IsAssignableTo implements Assertion
{
    /** @var Assertion<string> */
    private Assertion $assertion;

    public function __construct(private string $type)
    {
        (new IsType())
            ->assert($type);

        $this->assertion = $this->getAssertion($this->type);
    }

    /** @psalm-assert string */
    public function assert(mixed $value, string $message = ''): void
    {
        (new IsType())
            ->assert($value);

        try {
            $this->assertion->assert($value);
        }
        catch (AssertionFailed $ex) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected type %s to be assignable to %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->type),
            );

            throw new AssertionFailed($message, $ex->getCode(), $ex);
        }
    }

    /** @psalm-assert-if-true string $value */
    public function __invoke(mixed $value): bool
    {
        try {
            $this->assert($value);

            return true;
        }
        catch (AssertionFailed) {
            return false;
        }
    }

    /**
     * @param string $type
     *
     * @return Assertion<string>
     */
    private function getAssertion(string $type): Assertion
    {
        if ((new IsUnion())($type)) {
            return new IsAssignableToUnion($type);
        }

        if ((new IsIntersection())($type)) {
            return new IsAssignableToIntersection($type);
        }

        if ((new IsClassOrInterface())($type)) {
            return new IsAssignableToClass($type);
        }

        return new IsAssignableToPrimitive($type);
    }
}
