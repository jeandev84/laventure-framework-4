<?php
namespace Laventure\Component\Database\Connection;

use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Adapter\QueryNullStatement;

class NullConnection implements ConnectionInterface
{

    /**
     * @inheritDoc
    */
    public function getName(): string
    {
        return "";
    }



    /**
     * @inheritDoc
     */
    public function getDatabase(): string
    {
        return "";
    }



    /**
     * @inheritDoc
    */
    public function connect($config)
    {

    }



    /**
     * @inheritDoc
    */
    public function connected(): bool
    {
        return false;
    }




    /**
     * @inheritDoc
    */
    public function reconnect()
    {

    }



    /**
     * @inheritDoc
    */
    public function reconnected(): bool
    {
        return false;
    }



    /**
     * @inheritDoc
    */
    public function disconnect()
    {

    }




    /**
     * @inheritDoc
    */
    public function statement(string $sql, array $params = []): QueryInterface
    {
         return new QueryNullStatement($sql, $params);
    }





    /**
     * @inheritDoc
    */
    public function getConnection()
    {
         return null;
    }




    /**
     * @inheritDoc
     */
    public function beginTransaction()
    {

    }




    /**
     * @inheritDoc
     */
    public function commit()
    {

    }



    /**
     * @inheritDoc
    */
    public function rollback()
    {

    }




    /**
     * @inheritDoc
    */
    public function lastInsertId($name = null): int
    {
          return 0;
    }



    /**
     * @inheritDoc
    */
    public function exec($sql): bool
    {
        return false;
    }




    /**
     * @inheritDoc
     */
    public function getQueriesLog(): array
    {
        return [];
    }




    /**
     * @inheritDoc
    */
    public function createDatabase(): bool
    {
        return false;
    }



    /**
     * @inheritDoc
    */
    public function dropDatabase(): bool
    {
        return false;
    }




    /**
     * @inheritDoc
    */
    public function showDatabases(): array
    {
        return [];
    }




    /**
     * @inheritDoc
    */
    public function showDatabaseTables(): array
    {
        return [];
    }




    /**
     * @inheritDoc
    */
    public function databaseExists(): bool
    {
        return false;
    }
}