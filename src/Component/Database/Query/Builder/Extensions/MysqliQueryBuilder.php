<?php
namespace Laventure\Component\Database\Query\Builder\Extensions;

use Laventure\Component\Database\Connection\Extensions\Mysqli\MysqliConnection;
use Laventure\Component\Database\Query\Builder\Builder;


class MysqliQueryBuilder extends Builder
{
     /**
      * @param MysqliConnection $connection
      * @param string $table
     */
     public function __construct(MysqliConnection $connection, string $table)
     {
          parent::__construct($connection, $table);
     }
}