<?php
namespace Lexus\Component\Database\ORM;

use Exception;
use Lexus\Component\Database\Connection\Configuration\Configuration;
use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\Contract\HasDatabaseOperationInterface;
use Lexus\Component\Database\Connection\Extensions\PDO\PdoConnection;
use Lexus\Component\Database\Connection\Query\QueryInterface;
use Lexus\Component\Database\Manager\DatabaseManager;
use Lexus\Component\Database\ORM\Exception\ManagerException;
use Lexus\Component\Database\ORM\Mapper\Manager\Contract\EntityManagerInterface;
use Lexus\Component\Database\ORM\Mapper\Manager\NullEntityManager;
use Lexus\Component\Database\Query\QueryBuilder;
use Lexus\Component\Database\Schema\Migration\Migrator;
use Lexus\Component\Database\Schema\Schema;


class Manager
{


     /**
      * @var DatabaseManager
     */
     protected $databaseManager;




     /**
      * @var EntityManagerInterface
     */
     protected $manager;




     /**
      * @var Configuration
     */
     protected $config;




     /**
      * @var self
     */
     protected static $instance;




     /**
      * Manager Constructor
     */
     public function __construct()
     {
         $this->databaseManager = new DatabaseManager();
         $this->config          = new Configuration([]);
     }




     /**
      * @param array $credentials
      * @return void
     */
     public function addConnection(array $credentials): void
     {
          if (! static::$instance) {

              [$driver, $config] = $this->resolve($credentials);

              $this->databaseManager->connect($driver, $config);

              $this->manager = new NullEntityManager();
              $this->config  = new Configuration($config);

              static::$instance = $this;
          }
     }




     /**
      * @param string|null $name
      * @return ConnectionInterface|null
     */
     public function connection(string $name = null): ?ConnectionInterface
     {
          if ($connection = $this->databaseManager->connection($name)) {
              if($connection->databaseExists()) {
                   $connection->reconnect();
              }
         }

         return $connection;
     }




     /**
      * @param EntityManagerInterface $manager
      * @return $this
     */
     public function setManager(EntityManagerInterface $manager): static
     {
           $this->manager = $manager;

           return $this;
     }




     /**
      * @return EntityManagerInterface
     */
     public function getManager(): EntityManagerInterface
     {
          return $this->manager;
     }




     /**
      * @param string $sql
      * @param array $params
      * @return QueryInterface
     */
     public function statement(string $sql, array $params = []): QueryInterface
     {
          return $this->connection()->statement($sql, $params);
     }






     /**
      * @param string|null $name
      * @return Schema
     */
     public function schema(string $name = null): Schema
     {
          return new Schema($this->connection($name));
     }




     /**
      * @param string $name
      * @return QueryBuilder
     */
     public function table(string $name): QueryBuilder
     {
          return new QueryBuilder($this->connection(), $name);
     }





     /**
      * @param string $table
      * @return Migrator
     */
     public function migration(string $table): Migrator
     {
          return new Migrator($this->connection(), $table);
     }






     /**
      * @return $this
     */
     public static function instance(): static
     {
          if (! self::$instance) {
              (function () {
                  throw new ManagerException("No connection detected in ". get_class());
              })();
          }

          return self::$instance;
     }




     /**
      * @param string|null $name
      * @return void
     */
     public function disconnect(string $name = null): void
     {
          $this->databaseManager->disconnect();
     }




     /**
      * @param string|null $name
      * @return void
     */
     public function reconnect(string $name = null): void
     {
          $this->databaseManager->reconnect($name);
     }




     /**
      * @param string|null $name
      * @return void
     */
     public function purge(string $name = null): void
     {
          $this->databaseManager->purge($name);
     }




     /**
      * @param string $name
      * @return mixed
     */
     public function config(string $name): mixed
     {
          return $this->config->get($name);
     }




     /**
      * @param array $credentials
      * @return array
     */
     private function resolve(array $credentials): array
     {
          if (empty($credentials)) {
              throw new \InvalidArgumentException("Empty credentials for connection to database.");
          }

          if (empty($credentials['connection'])) {
              throw new \InvalidArgumentException("Unable connection name.");
          }

          $connection = $credentials['connection'];

          return [$connection, $credentials[$connection]];
     }
}