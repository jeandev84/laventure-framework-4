<?php
namespace Laventure\Component\Database\Connection\Extensions\Mysqli;

use Laventure\Component\Database\Connection\Query\QueryInterface;


class Statement implements QueryInterface
{

    public function prepare(string $sql)
    {
        // TODO: Implement prepare() method.
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }

    public function fetch(): QueryHasResultInterface
    {
        // TODO: Implement fetch() method.
    }
}