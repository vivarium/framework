<?php

declare(strict_types=1);

namespace Vivarium\Guard\Collection;

use Vivarium\Collection\Pair\Pair;
use Vivarium\Type\Assertion\IsAssignableVar;
use Vivarium\Type\Tuple;
use Vivarium\Type\Type;
use Vivarium\Type\Typed;

/**
 * @template K
 * @template V
 * @template-extends Pair<K, V>
 */
final class PairGuard extends Pair implements Typed
{
    private Tuple $types;

    public function __construct(Type $keyType, Type $valueType, Pair $pair)
    {
        (new IsAssignableVar($keyType))
            ->assert($pair->getKey());

        (new IsAssignableVar($valueType))
            ->assert($pair->getValue());

        parent::__construct($pair->getKey(), $pair->getValue());

        $this->types = new Tuple($keyType, $valueType);
    }

    public function getTuple() : Tuple
    {
        return $this->types;
    }
}
