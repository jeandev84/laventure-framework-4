<?php
namespace Laventure\Component\Database\Connection\Query;


class QueryNullStatement implements QueryInterface
{

    /**
     * @inheritDoc
     */
    public function prepare(string $sql, array $params = []): static
    {
         return $this;
    }



    /**
     * @inheritDoc
    */
    public function map(string $classname): static
    {
        return $this;
    }

    /**
     * @inheritDoc
    */
    public function execute()
    {
         return false;
    }




    /**
     * @inheritDoc
    */
    public function executeSQL(string $sql): bool
    {
         return false;
    }




    /**
     * @inheritDoc
    */
    public function fetch(): QueryResultInterface
    {
        return new QueryNullResult();
    }


    /**
     * @inheritDoc
    */
    public function lastInsertId(): int
    {
         return 0;
    }
}