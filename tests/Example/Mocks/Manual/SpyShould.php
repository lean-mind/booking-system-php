<?php

namespace LeanMind\Tests\Example\Mocks\Manual;

use LeanMind\Tests\Example\Bar;
use LeanMind\Tests\Example\Foo;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BarSpy implements Bar
{
    private string $returnValue;
    public int $calledCount = 0 {
        get {
            return $this->calledCount;
        }
    }

    public function __construct(string $returnValue)
    {
        $this->returnValue = $returnValue;
    }

    public function doYourStuff(): string
    {
        $this->calledCount++;
        return $this->returnValue;
    }

}


class SpyShould extends TestCase
{
    #[Test]
    public function run_foo_successfully()
    {
        $spy = new BarSpy('stuff');
        $foo = new Foo($spy);

        $this->assertEquals([
            'status' => 'success',
            'data' => 'stuff'
        ], $foo->run());

        $this->assertEquals(1, $spy->calledCount);
    }

    #[Test]
    public function run_foo_with_empty_bar()
    {
        $spy = new BarSpy('');
        $foo = new Foo($spy);

        $this->assertEquals([
            'status' => 'error',
            'error' => 'No stuff returned from Bar'
        ], $foo->run());
        $this->assertEquals(1, $spy->calledCount);
    }
}