<?php

declare(strict_types=1);

namespace Vivarium\Type\Assertion;

use InvalidArgumentException;
use Vivarium\Assertion\Assertion;
use Vivarium\Assertion\Helpers\TypeToString;
use Vivarium\Assertion\Object\IsInstanceOf;
use Vivarium\Assertion\String\IsEmpty;
use Vivarium\Type\Tuple;
use function sprintf;

final class IsAssignaleTuple implements Assertion
{
    private Tuple $tuple;

    public function __construct(Tuple $tuple)
    {
        $this->tuple = $tuple;
    }

    /**
     * @param mixed $value
     */
    public function assert($value, string $message = '') : void
    {
        if (! ($this)($value)) {
            $message = sprintf(
                ! (new IsEmpty())($message) ?
                    $message : 'Expected Tuple to be assignable Got different tuple.',
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
        (new IsInstanceOf(Tuple::class))
            ->assert($value);

        return $this->tuple->accept($value);
    }
}
