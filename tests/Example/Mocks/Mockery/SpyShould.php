<?php

namespace LeanMind\Tests\Example\Mocks\Mockery;

use LeanMind\Tests\Example\Bar;
use LeanMind\Tests\Example\Foo;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;


class SpyShould extends TestCase
{
    #[Test]
    public function run_foo_successfully()
    {
        $spy = Mockery::spy(Bar::class);
        $spy->expects()->doYourStuff()
            ->andReturn('stuff');
        $foo = new Foo($spy);

        $this->assertEquals([
            'status' => 'success',
            'data' => 'stuff'
        ], $foo->run());
    }

    #[Test]
    public function run_foo_with_empty_bar()
    {
        $spy = Mockery::spy(Bar::class);
        $spy->expects()->doYourStuff()
            ->andReturn('');
        $foo = new Foo($spy);

        $this->assertEquals([
            'status' => 'error',
            'error' => 'No stuff returned from Bar'
        ], $foo->run());
    }
}