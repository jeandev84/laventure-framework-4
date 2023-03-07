<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO;

use Laventure\Component\Database\Connection\Query\QueryResultInterface;
use PDO;
use PDOStatement;


class QueryResult implements QueryResultInterface
{

    /**
     * @var PDOStatement
    */
    private $statement;


    /**
     * @param PDOStatement $statement
    */
    public function __construct(PDOStatement $statement)
    {
         $this->statement = $statement;
    }



    /**
     * @inheritDoc
    */
    public function map(string $classname): static
    {
         $this->statement->setFetchMode(PDO::FETCH_CLASS, $classname);

         return $this;
    }


    public function all(): bool|array
    {
        return $this->statement->fetchAll();
    }


    public function one(): mixed
    {
        return $this->statement->fetch();
    }

    public function column(): mixed
    {
        return $this->statement->fetchColumn();
    }


    public function columns(): bool|array
    {
        return $this->statement->fetchAll(PDO::FETCH_COLUMN);
    }



    public function assoc(): bool|array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function object(): mixed
    {
        return $this->statement->fetchObject();
    }

    public function count(): int
    {
        return $this->statement->rowCount();
    }
}