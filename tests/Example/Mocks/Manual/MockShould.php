<?php

namespace LeanMind\Tests\Example\Mocks\Manual;

use LeanMind\Tests\Example\Bar;
use LeanMind\Tests\Example\Foo;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BarMock implements Bar
{
    private string $returnValue;

    public function __construct(string $returnValue)
    {
        $this->returnValue = $returnValue;
    }

    public function doYourStuff(): string
    {
        return $this->returnValue;
    }
}


class MockShould extends TestCase
{
    #[Test]
    public function run_foo_successfully()
    {
        $foo = new Foo(new BarMock('stuff'));

        $this->assertEquals([
            'status' => 'success',
            'data' => 'stuff'
        ], $foo->run());
    }

    #[Test]
    public function run_foo_with_empty_bar()
    {
        $foo = new Foo(new BarMock(''));

        $this->assertEquals([
            'status' => 'error',
            'error' => 'No stuff returned from Bar'
        ], $foo->run());
    }
}