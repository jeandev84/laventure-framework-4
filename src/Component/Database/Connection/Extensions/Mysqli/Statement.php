<?php
namespace Lexus\Component\Database\Connection\Extensions\Mysqli;

use Lexus\Component\Database\Connection\Query\QueryInterface;


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