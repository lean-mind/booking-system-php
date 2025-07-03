<?php

declare(strict_types=1);

namespace LeanMind\Tests\Example;

use RuntimeException;
use Throwable;

class Foo
{
    private readonly Bar $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }

    public function run(): array
    {
        try {
            $stuff = $this->bar->doYourStuff();
            if (empty($stuff)) {
                throw new RuntimeException('No stuff returned from Bar');
            }
            return [
                'status' => 'success',
                'data' => $stuff
            ];
        } catch (Throwable $e) {
            return [
                'status' => 'error',
                'error' => $e->getMessage()
            ];
        }
    }

}