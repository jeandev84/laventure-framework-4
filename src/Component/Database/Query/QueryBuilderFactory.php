<?php
namespace Laventure\Component\Database\Query;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Extensions\Mysqli\MysqliConnection;
use Laventure\Component\Database\Connection\Extensions\PDO\PdoConnection;
use Laventure\Component\Database\Query\Builder\Builder;
use Laventure\Component\Database\Query\Builder\Extensions\MysqliQueryBuilder;
use Laventure\Component\Database\Query\Builder\Extensions\PdoQueryBuilder;


class QueryBuilderFactory
{
      /**
        * @param ConnectionInterface $connection
        * @param string $table
        * @return Builder
      */
      public static function make(ConnectionInterface $connection, string $table): Builder
      {
            if ($connection instanceof PdoConnection) {
                 return new PdoQueryBuilder($connection, $table);
            }

            if ($connection instanceof MysqliConnection) {
                 return new MysqliQueryBuilder($connection, $table);
            }

            return new Builder($connection, $table);
      }
}