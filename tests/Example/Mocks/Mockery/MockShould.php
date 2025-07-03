<?php

namespace LeanMind\Tests\Example\Mocks\Mockery;

use LeanMind\Tests\Example\Bar;
use LeanMind\Tests\Example\Foo;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;


class MockShould extends TestCase
{
    #[Test]
    public function run_foo_successfully()
    {
        $mock = Mockery::mock(Bar::class);
        $mock->shouldReceive('doYourStuff')
            ->andReturn('stuff');
        $foo = new Foo($mock);

        $this->assertEquals([
            'status' => 'success',
            'data' => 'stuff'
        ], $foo->run());
    }

    #[Test]
    public function run_foo_with_empty_bar()
    {
        $mock = Mockery::mock(Bar::class);
        $mock->shouldReceive('doYourStuff')
            ->andReturn('');
        $foo = new Foo($mock);

        $this->assertEquals([
            'status' => 'error',
            'error' => 'No stuff returned from Bar'
        ], $foo->run());
    }
}