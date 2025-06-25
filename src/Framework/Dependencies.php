<?php

declare(strict_types=1);

namespace LeanMind\Framework;

use Exception;

class Dependencies
{
    private array $dependencies = [];

    /**
     * Load a dependency by its name.
     *
     * @param string $dependency The name of the dependency to load.
     * @return object The loaded dependency instance.
     * @throws Exception If the dependency is not found.
     */
    public function load(string $dependency): object
    {
        if (!$this->has($dependency)) {
            throw new Exception("Dependency '$dependency' not found.");
        }
        return $this->dependencies[$dependency];
    }

    /**
     * Register a dependency with a name and instance.
     *
     * @param string $name The name of the dependency.
     * @param object $instance The instance of the dependency.
     * @throws Exception if the dependency is already registered.
     */
    public function register(string $name, object $instance): void
    {
        if ($this->has($name)) {
            throw new Exception("Dependency '$name' is already registered.");
        }
        $this->dependencies[$name] = $instance;
    }

    public function has(string $name): bool
    {
        return isset($this->dependencies[$name]);
    }

}