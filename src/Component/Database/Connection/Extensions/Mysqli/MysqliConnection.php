<?php
namespace Laventure\Component\Database\Connection\Extensions\Mysqli;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;

class MysqliConnection implements ConnectionInterface, MysqliConnectionInterface
{

    /**
     * @inheritDoc
    */
    public function getName(): string
    {
        return 'mysqli';
    }




    /**
     * @inheritDoc
     */
    public function connect($config)
    {
        // TODO: Implement connect() method.
    }



    /**
     * @inheritDoc
    */
    public function connected(): bool
    {
        // TODO: Implement connected() method.
    }

    /**
     * @inheritDoc
     */
    public function reconnect()
    {
        // TODO: Implement reconnect() method.
    }

    /**
     * @inheritDoc
     */
    public function disconnect()
    {
        // TODO: Implement disconnect() method.
    }

    /**
     * @inheritDoc
     */
    public function statement(string $sql, array $params = []): QueryInterface
    {
        // TODO: Implement statement() method.
    }

    /**
     * @inheritDoc
     */
    public function getConnection()
    {
        // TODO: Implement getConnection() method.
    }

    /**
     * @inheritDoc
     */
    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    /**
     * @inheritDoc
     */
    public function commit()
    {
        // TODO: Implement commit() method.
    }

    /**
     * @inheritDoc
     */
    public function rollback()
    {
        // TODO: Implement rollback() method.
    }

    /**
     * @inheritDoc
     */
    public function lastInsertId($name = null): int
    {
        // TODO: Implement lastInsertId() method.
    }

    /**
     * @inheritDoc
     */
    public function exec($sql): bool
    {
        // TODO: Implement exec() method.
    }

    /**
     * @inheritDoc
     */
    public function getQueriesLog(): array
    {
        // TODO: Implement getQueriesLog() method.
    }

    /**
     * @inheritDoc
     */
    public function getMysqli(): \mysqli
    {
        // TODO: Implement getMysqli() method.
    }



    /**
     * @inheritDoc
     */
    public function getDatabase(): string
    {
        // TODO: Implement getDatabase() method.
    }

    /**
     * @inheritDoc
     */
    public function reconnected(): bool
    {
        // TODO: Implement reconnected() method.
    }

    /**
     * @inheritDoc
     */
    public function createDatabase(): bool
    {
        // TODO: Implement createDatabase() method.
    }

    /**
     * @inheritDoc
     */
    public function dropDatabase(): bool
    {
        // TODO: Implement dropDatabase() method.
    }

    /**
     * @inheritDoc
     */
    public function showDatabases(): array
    {
        // TODO: Implement showDatabases() method.
    }

    /**
     * @inheritDoc
     */
    public function showDatabaseTables(): array
    {
        // TODO: Implement showDatabaseTables() method.
    }

    /**
     * @inheritDoc
     */
    public function databaseExists(): bool
    {
        // TODO: Implement databaseExists() method.
    }
}