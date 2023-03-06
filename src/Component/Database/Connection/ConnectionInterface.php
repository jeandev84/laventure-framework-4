<?php
namespace Laventure\Component\Database\Connection;

use Laventure\Component\Database\Connection\Query\QueryInterface;
use Traversable;

interface ConnectionInterface
{


    /**
     * Get connection name
     *
     * @return string
    */
    public function getName(): string;


    /**
     * Get name of database
     *
     * @return string
    */
    public function getDatabase(): string;





    /**
     * Connect to the database
     *
     * @param array|Traversable $config
     * @return mixed
    */
    public function connect($config);



    /**
     * Determine if the connection established
     *
     * @return bool
    */
    public function connected(): bool;




    /**
     * Reconnection to the database
     *
     * @return mixed
    */
    public function reconnect();





    /**
     * Determine reconnection status
     *
     * @return bool
    */
    public function reconnected(): bool;






    /**
     * Disconnect to the database
     *
     * @return mixed
    */
    public function disconnect();




    /**
     * Make a query statement
     *
     * @param string $sql
     * @param array $params
     * @return QueryInterface
    */
    public function statement(string $sql, array $params = []): QueryInterface;





    /**
     * @return mixed
    */
    public function getConnection();




    /**
     * Begin a transaction query
     *
     * @return mixed
    */
    public function beginTransaction();





    /**
     * Commit transaction
     *
     * @return mixed
    */
    public function commit();





    /**
     * Rollback transaction
     *
     * @return mixed
    */
    public function rollback();




    /**
     * Get last insert id
     *
     * @param $name
     * @return int
    */
    public function lastInsertId($name = null): int;






    /**
     * Execute query
     *
     * @param $sql
     * @return bool
    */
    public function exec($sql): bool;





    /**
     * Get executed queries
     *
     * @return array
    */
    public function getQueriesLog(): array;




    /**
     * Create database
     *
     * @return bool
    */
    public function createDatabase(): bool;




    /**
     * Drop database
     *
     * @return bool
    */
    public function dropDatabase(): bool;




    /**
     * Show all databases
     *
     * @return array
    */
    public function showDatabases(): array;





    /**
     * @return array
    */
    public function showDatabaseTables(): array;





    /**
     * @return bool
    */
    public function databaseExists(): bool;
}