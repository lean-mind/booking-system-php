<?php

namespace LeanMind\Tests\Example\Mocks\Manual;

use LeanMind\Tests\Example\Bar;
use LeanMind\Tests\Example\Foo;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StuffBarStub implements Bar
{
    public function doYourStuff(): string
    {
        return 'stuff';
    }
}

class EmptyBarStub implements Bar
{
    public function doYourStuff(): string
    {
        return '';
    }
}


class StubShould extends TestCase
{
    #[Test]
    public function run_foo_successfully()
    {
        $foo = new Foo(new StuffBarStub());

        $this->assertEquals([
            'status' => 'success',
            'data' => 'stuff'
        ], $foo->run());
    }

    #[Test]
    public function run_foo_with_empty_bar()
    {
        $foo = new Foo(new EmptyBarStub());

        $this->assertEquals([
            'status' => 'error',
            'error' => 'No stuff returned from Bar'
        ], $foo->run());
    }
}