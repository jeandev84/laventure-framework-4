<?php
namespace Lexus\Component\Database\Schema\BluePrint;

use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\ConnectionType;
use Lexus\Component\Database\Schema\BluePrint\Drivers\MysqlBluePrint;
use Lexus\Component\Database\Schema\BluePrint\Drivers\OracleBluePrint;
use Lexus\Component\Database\Schema\BluePrint\Drivers\PgsqlBlueprint;
use Lexus\Component\Database\Schema\BluePrint\Drivers\SqliteBluePrint;

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