<?php

declare(strict_types=1);

namespace LeanMind\Framework;

use Exception;
use LeanMind\Libraries\DB\EntityManager;
use LeanMind\Libraries\Redsys\RedsysClient;
use LeanMind\Libraries\Stripe\StripeClient;

abstract class Controller
{
    private Dependencies $dependencies;

    /**
     * Controller constructor.
     * @throws Exception if the dependency is already registered
     */
    public function __construct()
    {
        $this->dependencies = new Dependencies();
        $this->dependencies->register('EntityManager', new EntityManager());
        $this->dependencies->register('RedsysClient', new RedsysClient());
        $this->dependencies->register('StripeClient', new StripeClient());
    }


    /**
     * Load a dependency by its name.
     *
     * @param string $dependency The name of the dependency to register.
     * @return object The instance of the registered dependency.
     * @throws Exception if the dependency is not found.
     */
    function load(string $dependency): object
    {
        return $this->dependencies->load($dependency);
    }

}