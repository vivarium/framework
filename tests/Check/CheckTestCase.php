<?php

namespace Vivarium\Test\Check;

use PHPUnit\Framework\TestCase;

use function call_user_func;
use function ucfirst;

abstract class CheckTestCase extends TestCase
{
    const SUCCESS = 'provideSuccess';
    const FAILURE = 'provideFailure';

    protected function doTest(string|object $class, string $method, string $namespace): void
    {
        $this->doTestSuccess($class, $method, $namespace);
        $this->doTestFailure($class, $method, $namespace);
    }

    private function doTestSuccess(string|object $class, string $method, string $namespace): void
    {
        foreach ($this->getTests($namespace, $method, static::SUCCESS) as $test) {
            static::assertTrue(
                call_user_func(
                    [$class, $method],
                    ...$test
                )
            );
        }
    }

    private function doTestFailure(string|object $class, string $method, string $namespace): void
    {
        foreach ($this->getTests($namespace, $method, static::FAILURE) as $test) {
            static::assertFalse(
                call_user_func(
                    [$class, $method],
                    ...array_slice($test, 0, count($test) - 1)
                )
            );
        }
    }
    
    private function getTests(string $namespace, string $method, string $provider): array
    {
        return call_user_func(
            [$namespace . '\\' . ucfirst($method) . 'Test', $provider]
        );
    }
}
