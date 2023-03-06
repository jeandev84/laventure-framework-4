<?php
namespace Lexus\Component\Database\Schema;


use Closure;
use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\Contract\HasDatabaseOperationInterface;
use Lexus\Component\Database\Schema\BluePrint\BluePrintFactory;

class Schema implements SchemaInterface
{


    /**
     * @var ConnectionInterface
    */
    protected $connection;




    /**
     * @param ConnectionInterface $connection
    */
    public function __construct(ConnectionInterface $connection)
    {
         $this->connection = $connection;
    }



    /**
     * @inheritDoc
    */
    public function create(string $table, Closure $closure): bool
    {
         $blueprint = BluePrintFactory::create($this->connection, $table);

         $closure($blueprint);

         return $blueprint->createTable();
    }



    /**
     * @inheritDoc
    */
    public function table(string $table, Closure $closure): bool
    {
         $blueprint = BluePrintFactory::create($this->connection, $table);

         $closure($blueprint);

         return $blueprint->updateTable();
    }




    /**
     * @inheritDoc
    */
    public function drop(string $table): bool
    {
        return BluePrintFactory::create($this->connection, $table)->dropTable();
    }




    /**
     * @inheritDoc
    */
    public function truncate(string $table): bool
    {
         return BluePrintFactory::create($this->connection, $table)->truncateTable();
    }




    /**
     * @inheritDoc
    */
    public function showColumns(string $table): array
    {
         return BluePrintFactory::create($this->connection, $table)->showColumns();
    }



    /**
     * @inheritDoc
    */
    public function describe(string $table): mixed
    {
        return BluePrintFactory::create($this->connection, $table)->describeTable();
    }




    /**
     * @inheritDoc
    */
    public function exists(string $table): bool
    {
        return in_array($table, $this->showTables());
    }




    /**
     * @return array
    */
    public function showTables(): array
    {
          return $this->connection->showDatabaseTables();
    }



    /**
     * @param Closure $closure
     * @return bool
    */
    public function transaction(Closure $closure): bool
    {

        try {

              $this->connection->beginTransaction();

              $closure($this);

              $this->connection->commit();

              return true;

        } catch (\Exception $exception) {

              $this->connection->rollback();
        }

        return false;
    }




    /**
     * @inheritDoc
    */
    public function exec(string $sql): bool
    {
        return $this->connection->exec($sql);
    }
}