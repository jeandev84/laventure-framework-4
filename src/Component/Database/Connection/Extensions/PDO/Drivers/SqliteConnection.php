<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO\Drivers;


use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\ConnectionType;
use Laventure\Component\Database\Connection\Extensions\PDO\PdoConnection;
use Laventure\Component\Database\Connection\Traits\HasDatabase;

class SqliteConnection extends PdoConnection implements ConnectionInterface
{

     use HasDatabase;


     /**
      * @inheritDoc
     */
     public function getName(): string
     {
         return ConnectionType::pdo_sqlite;
     }



      /**
       * @inheritDoc
      */
      public function connect($config)
      {
          parent::connect([
              'dsn' => "sqlite:{$config['database']}",
              'username' => null,
              'password' => null,
              'options'  => []
          ]);
      }




     /**
      * @inheritDoc
     */
     public function createDatabase(): bool
     {
         $database = $this->getDatabase();

         $this->exec("CREATE DATABASE IF NOT EXISTS {$database};");

         return in_array($database, $this->showDatabases());
     }



     /**
      * @inheritDoc
     */
     public function dropDatabase(): bool
     {
         $database = $this->getDatabase();

         $this->exec("DROP DATABASE IF EXISTS {$database};");

         return ! in_array($database, $this->showDatabases());
     }



     /**
      * @inheritDoc
     */
     public function showDatabases(): array
     {
         return $this->statement('SHOW DATABASES')
                     ->fetch()
                     ->columns();
     }




    /**
     * @inheritDoc
    */
    public function showDatabaseTables(): array
    {
         return [];
    }
}