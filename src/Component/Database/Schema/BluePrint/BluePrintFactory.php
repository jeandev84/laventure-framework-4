<?php
namespace Laventure\Component\Database\Schema\BluePrint;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\ConnectionType;
use Laventure\Component\Database\Schema\BluePrint\Drivers\MysqlBluePrint;
use Laventure\Component\Database\Schema\BluePrint\Drivers\OracleBluePrint;
use Laventure\Component\Database\Schema\BluePrint\Drivers\PgsqlBlueprint;
use Laventure\Component\Database\Schema\BluePrint\Drivers\SqliteBluePrint;

class BluePrintFactory
{
     public static function create(ConnectionInterface $connection, string $table): BluePrint
     {
          return [
             ConnectionType::pdo_mysql  => new MysqlBluePrint($connection, $table),
             ConnectionType::pdo_pgsql  => new PgsqlBlueprint($connection, $table),
             ConnectionType::pdo_sqlite => new SqliteBluePrint($connection, $table),
             ConnectionType::pdo_oci    => new OracleBluePrint($connection, $table),
          ][$connection->getName()];
     }
}