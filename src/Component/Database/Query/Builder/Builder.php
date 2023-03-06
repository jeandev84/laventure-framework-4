<?php
namespace Lexus\Component\Database\Query\Builder;


use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Delete;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Insert;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Select;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Update;


class Builder extends SqlQueryBuilder implements BuilderInterface
{


    /**
     * @var string
    */
    protected $table;


    /**
     * @param ConnectionInterface $connection
     * @param string $table
     */
    public function __construct(ConnectionInterface $connection, string $table)
    {
        parent::__construct($connection);
        $this->table = $table;
    }




    /**
     * @return string
    */
    public function getTable(): string
    {
        return $this->table;
    }




    /**
     * @inheritDoc
    */
    public function select(string $selects = null, array $wheres = []): Select
    {
        $command = $this->selectQuery($selects ?: "*", $this->table);
        $command->addConditions($wheres);
        return $command;
    }




    /**
     * @inheritDoc
    */
    public function insert(array $attributes): Insert
    {
          return $this->insertQuery($attributes, $this->table);
    }





    /**
     * @inheritDoc
    */
    public function update(array $attributes, array $wheres): Update
    {
        $command = $this->updateQuery($attributes, $this->table);
        $command->addConditions($wheres);
        return $command;
    }




    /**
     * @inheritDoc
     */
    public function delete(array $wheres): Delete
    {
        $command = $this->deleteQuery($this->table);
        $command->addConditions($wheres);
        return $command;
    }
}