<?php

namespace Vivarium\Test\Check;

use Vivarium\Check\Check;
use Vivarium\Check\Exception\NoSuchMethod;
use Vivarium\Check\Exception\TooFewArguments;
use Vivarium\Check\Exception\TooMuchArguments;

/**
 * @coversDefaultClass \Vivarium\Check\Check
 */
final class CheckTest extends CheckTestCase
{
    const COMPARISON_NAMESPACE = 'Vivarium\Test\Assertion\Comparison';
    const ENCODING_NAMESPACE   = 'Vivarium\Test\Assertion\Encoding';
    const STRING_NAMESPACE     = 'Vivarium\Test\Assertion\String';

    /**
     * @covers ::__construct()
     * @covers ::boolean()
     * @covers ::__call()
     */
    public function testBoolean(): void
    {
        $check = Check::boolean();

        static::assertTrue($check->isTrue(true));
        static::assertTrue($check->isFalse(false));

        static::assertFalse($check->isTrue(false));
        static::assertFalse($check->isFalse(true));
    }

    /**
     * @covers ::__construct()
     * @covers ::comparison()
     * @covers ::__call()
     * 
     * @dataProvider Vivarium\Test\Check\CheckIfElementTest::provideMethods()
     */
    public function testComparison($method): void
    {
        $this->doTest(
            Check::comparison(), 
            $method, 
            static::COMPARISON_NAMESPACE
        );
    }

        /**
     * @covers ::__construct()
     * @covers ::encoding()
     * @covers ::__call()
     * 
     * @dataProvider Vivarium\Test\Check\CheckIfEncodingTest::provideMethods()
     */
    public function testEncoding($method): void
    {
        $this->doTest(
            Check::encoding(), 
            $method, 
            static::ENCODING_NAMESPACE
        );
    }

    /**
     * @covers ::__construct()
     * @covers ::string()
     * @covers ::__call()
     * 
     * @dataProvider Vivarium\Test\Check\CheckIfStringTest::provideMethods()
     */
    public function testString(string $method): void
    {
        $this->doTest(
            Check::string(), 
            $method, 
            static::STRING_NAMESPACE
        );
    }

    /**
     * @covers ::__construct()
     * @covers ::__call()
     */
    public function testNoSuchMethod(): void
    {
        static::expectException(NoSuchMethod::class);
        static::expectExceptionMessage(
            'No such method nonExistentMethod. Missing class Vivarium\Assertion\String\NonExistentMethod'
        );

        $check = Check::string();
        $check->nonExistentMethod();
    }

    /**
     * @covers ::__construct()
     * @covers ::__call()
     */
    public function testTooFewArguments(): void
    {
        static::expectException(TooFewArguments::class);
        static::expectExceptionMessage(
            'Too few arguments provided. Expected 1, got 0'
        );

        $check = Check::boolean();
        $check->isTrue();
    }

    /**
     * @covers ::__construct()
     * @covers ::__call()
     */
    public function testTooMuchArguments(): void
    {
        static::expectException(TooMuchArguments::class);
        static::expectExceptionMessage(
            'Too much arguments provided. Expected 1, got 2'
        );

        $check = Check::boolean();
        $check->isTrue(true, false);
    }
}
