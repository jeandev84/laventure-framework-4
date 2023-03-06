<?php
namespace Laventure\Component\Database\Query\Builder;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Update;

class SqlQueryBuilder implements SqlQueryBuilderInterface
{
    /**
     * @var ConnectionInterface
    */
    protected $connection;



    /**
     * @param ConnectionInterface $connection
    */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }



    /**
     * @inheritDoc
    */
    public function selectQuery(string $selects, string $table): Select
    {
         $command = new Select($this->connection, $table);
         $command->addSelect($selects);
         return $command;
    }



    /**
     * @inheritDoc
    */
    public function insertQuery(array $attributes, string $table): Insert
    {
         $command = new Insert($this->connection, $table);
         $command->withAttributes($attributes);
         return $command;
    }




    /**
     * @inheritDoc
    */
    public function updateQuery(array $attributes, string $table): Update
    {
         return new Update($this->connection, $table);
    }




    /**
     * @inheritDoc
    */
    public function deleteQuery($table): Delete
    {
        return new Delete($this->connection, $table);
    }
}