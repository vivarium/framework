<?php

namespace Vivarium\Check;

use ReflectionClass;
use Vivarium\Assertion\Type\IsNamespace;
use Vivarium\Check\Exception\NoSuchMethod;
use Vivarium\Check\Exception\TooFewArguments;
use Vivarium\Check\Exception\TooMuchArguments;

use function class_exists;

final class Check
{
    private string $namespace;

    private function __construct(string $namespace)
    {
        (new IsNamespace)
            ->assert($namespace);

        $this->namespace = $namespace;
    }

    public static function boolean(): Check
    {
        return new Check('Vivarium\Assertion\Boolean');
    }

    public static function comparison(): Check
    {
        return new Check('Vivarium\Assertion\Comparison',);
    }

    public static function encoding(): Check
    {
        return new Check('Vivarium\Assertion\Encoding',);
    }

    public static function numeric(): Check
    {
        return new Check('Vivarium\Assertion\Numeric');
    }

    public static function object(): Check
    {
        return new Check('Vivarium\Assertion\Object');
    }

    public static function string(): Check
    {
        return new Check('Vivarium\Assertion\String');
    }

    public static function type(): Check
    {
        return new Check('Vivarium\Assertion\Type');
    }

    public static function var(): Check
    {
        return new Check('Vivarium\Assertion\Var');
    }

    public function __call($name, $arguments)
    {
        $assertion = $this->namespace . '\\' . ucfirst($name);
        if (! class_exists($assertion)) {
            throw new NoSuchMethod($name, $assertion);
        }

        $reflector = new ReflectionClass($assertion);

        $check       = $reflector->getMethod('__invoke');
        $constructor = $reflector->getConstructor();

        $checkParametersCount       = count($check->getParameters());
        $constructorParametersCount = $constructor === null ? 0 : count($constructor->getParameters());

        $parametersCount = $checkParametersCount + $constructorParametersCount;
        $argumentsCount  = count($arguments);

        if ($parametersCount > $argumentsCount) {
            throw new TooFewArguments($parametersCount, $argumentsCount);
        }

        if ($parametersCount < $argumentsCount) {
            throw new TooMuchArguments($parametersCount, $argumentsCount);
        }

        $checkArguments       = array_slice($arguments, 0, $checkParametersCount);
        $constructorArguments = array_slice($arguments, $checkParametersCount);

        $fn = new $assertion(...$constructorArguments);

        return $fn(...$checkArguments);
    }
}
