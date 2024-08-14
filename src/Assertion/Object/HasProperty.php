<?php

declare(strict_types=1);

namespace Vivarium\Assertion\Object;

use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Exception\AssertionFailed;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Assertion\Var\IsObject;

use function method_exists;
use function sprintf;

/** @template-implements Assertion<class-string|object> */
final class HasProperty implements Assertion
{
    public function __construct(private string $property)
    {
    }

    public function assert(mixed $value, string $message = ''): void
    {
        if (! $this($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected %s to have a method named %2$s.',
                (new TypeToString())($value),
                (new TypeToString())($this->property),
            );

            throw new AssertionFailed($message);
        }
    }

    public function __invoke(mixed $value): bool
    {
        (new IsObject())
            ->assert($value);

        return property_exists($value, $this->property);
    }
}
