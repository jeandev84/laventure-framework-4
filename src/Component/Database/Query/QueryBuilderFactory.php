<?php
namespace Lexus\Component\Database\Query;

use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\Extensions\Mysqli\MysqliConnection;
use Lexus\Component\Database\Connection\Extensions\PDO\PdoConnection;
use Lexus\Component\Database\Query\Builder\Builder;
use Lexus\Component\Database\Query\Builder\Extensions\MysqliQueryBuilder;
use Lexus\Component\Database\Query\Builder\Extensions\PdoQueryBuilder;


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