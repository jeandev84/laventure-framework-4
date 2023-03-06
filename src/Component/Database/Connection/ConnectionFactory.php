<?php
namespace Laventure\Component\Database\Connection;



use Laventure\Component\Database\Connection\Extensions\Mysqli\MysqliConnection;
use Laventure\Component\Database\Connection\Extensions\PDO\Drivers\MysqlConnection;
use Laventure\Component\Database\Connection\Extensions\PDO\Drivers\OracleConnection;
use Laventure\Component\Database\Connection\Extensions\PDO\Drivers\PgsqlConnection;
use Laventure\Component\Database\Connection\Extensions\PDO\Drivers\SqliteConnection;

class ConnectionFactory
{

      /**
       * @param $name
       * @param array $config
       * @return ConnectionInterface|null
      */
      public function make($name, array $config): ?ConnectionInterface
      {
          $connections = [
              ConnectionType::pdo_mysql  => new MysqlConnection(),
              ConnectionType::pdo_pgsql  => new PgsqlConnection(),
              ConnectionType::pdo_sqlite => new SqliteConnection(),
              ConnectionType::pdo_oci    => new OracleConnection(),
              ConnectionType::mysqli     => new MysqliConnection()
          ];


          if (! isset($connections[$name])) {
              return null;
          }

          $connections[$name]->connect($config);

          return $connections[$name];
      }
}