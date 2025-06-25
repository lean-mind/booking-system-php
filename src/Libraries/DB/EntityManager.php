<?php

declare(strict_types=1);

namespace LeanMind\Libraries\DB;

use RuntimeException;

final class EntityManager
{

    /**
     * Execute a SQL query with parameters.
     * @param string $sql The SQL statement to execute.
     * @param array $params An associative array of parameters to bind to the SQL statement.
     */
    function query(string $sql, array $params = []): mixed
    {
        throw new RuntimeException("Error to connect to database");
    }

    /**
     * Execute a SQL statement with parameters.
     * @param string $sql The SQL statement to execute.
     * @param array $params An associative array of parameters to bind to the SQL statement.
     * @return mixed The result of the execution.
     */
    function execute(string $sql, array $params = []): mixed
    {
        throw new RuntimeException("Error to connect to database");
    }
}