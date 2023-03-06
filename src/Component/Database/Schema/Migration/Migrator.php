<?php
namespace Laventure\Component\Database\Schema\Migration;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\QueryBuilder;
use Laventure\Component\Database\Schema\BluePrint\BluePrint;
use Laventure\Component\Database\Schema\Migration\Contract\MigratorInterface;
use Laventure\Component\Database\Schema\Schema;



class Migrator implements MigratorInterface
{

       /**
        * @var string
       */
       protected $table;




       /**
        * @var MigrationCollection
       */
       protected $collection;




       /**
        * @var ConnectionInterface
       */
       protected $connection;




       /**
        * @var Schema
       */
       protected $schema;





       /**
        * @var QueryBuilder
       */
       protected $queryBuilder;





       /**
        * @param ConnectionInterface $connection
        * @param string $table
       */
       public function __construct(ConnectionInterface $connection, string $table)
       {
            $this->schema       = new Schema($connection);
            $this->collection   = new MigrationCollection();
            $this->queryBuilder = new QueryBuilder($connection, $table);
            $this->connection   = $connection;
            $this->table        = $table;
       }




       /**
        * Get table
        *
        * @return string
       */
       public function getTable(): string
       {
           return $this->table;
       }




       /**
        * @param Migration[] $migrations
        * @return $this
       */
       public function add(array $migrations): static
       {
           foreach ($migrations as $migration) {
               $this->collection->add($migration);
           }

           return $this;
       }





       /**
        * @inheritDoc
       */
       public function getMigrations(): array
       {
            return $this->collection->getMigrations();
       }




       /**
        * @return MigrationCollection
       */
       public function collection(): MigrationCollection
       {
           return $this->collection;
       }




       /**
        * @inheritDoc
       */
       public function getAppliedMigrations(): array
       {
           if (! $this->schema->exists($this->table)) {
                return [];
           }

           return $this->queryBuilder
                       ->select('version')
                       ->from($this->getTable())
                       ->getQuery()
                       ->getArrayColumns();
       }



      /**
       * @inheritDoc
       * @return Migration[]
      */
      public function diff(): array
      {
           return array_filter($this->getMigrations(), function (Migration $migration) {
              return ! in_array($migration->getName(), $this->getAppliedMigrations());
           });
      }



       /**
        * @inheritDoc
       */
       public function createTable(): bool
       {
           return $this->schema->create($this->table, function (BluePrint $table) {
                $table->id();
                $table->string('version');
                $table->datetime('executed_at');
           });
       }




        /**
         * @inheritDoc
        */
        public function migrate(): bool
        {
            $this->createTable();

            if ($migrations = $this->diff()) {
                foreach ($migrations as $migration) {
                    $migration->up();
                    $this->queryBuilder->insert([
                        'version'     => $migration->getName(),
                        'executed_at' => date('Y-m-d H:i:s')
                    ])->execute();
                }
            }

            return true;
        }





        /**
         * @inheritDoc
        */
        public function rollback(): bool
        {
            if (! $this->schema->exists($this->getTable())) {
                 return false;
            }

            foreach ($this->getMigrations() as $migration) {
                $migration->down();
            }

            return $this->schema->truncate($this->getTable());
        }





        /**
         * @inheritDoc
        */
        public function reset(): bool
        {
             $this->rollback();

             return $this->schema->drop($this->getTable());
        }



        /**
          * @inheritDoc
        */
        public function refresh(): bool
        {
             $this->reset();
             return $this->migrate();
        }
}