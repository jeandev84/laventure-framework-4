<?php
namespace Laventure\Component\Database\Schema\BluePrint;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Schema\BluePrint\Column\Column;
use Laventure\Component\Database\Schema\BluePrint\Column\ColumnCollection;
use Laventure\Component\Database\Schema\BluePrint\Column\DropColumn;
use Laventure\Component\Database\Schema\BluePrint\Column\ModifyColumn;
use Laventure\Component\Database\Schema\BluePrint\Column\NewColumn;
use Laventure\Component\Database\Schema\BluePrint\Column\RenameColumn;
use Laventure\Component\Database\Schema\BluePrint\Indexes\Index;
use Laventure\Component\Database\Schema\BluePrint\Keys\ForeignKey;
use Laventure\Component\Database\Schema\BluePrint\Keys\UniqueKey;


abstract class BluePrint implements BluePrintInterface
{


    /**
     * @var ConnectionInterface
    */
    protected $connection;




    /**
     * @var string
    */
    protected $table;




    /**
     * @var ColumnCollection
    */
    protected $collection;




    /**
     * @param ConnectionInterface $connection
     * @param string $table
    */
    public function __construct(ConnectionInterface $connection, string $table)
    {
         $this->connection = $connection;
         $this->table      = $table;
         $this->collection = new ColumnCollection();
    }




    /**
     * @return string
    */
    public function getTable(): string
    {
        return $this->table;
    }





    /**
     * @param string $name
     * @param string $type
     * @param array $options
     * @return Column
    */
    public function addColumn(string $name, string $type, array $options = []): Column
    {
          if ($this->existTable()) {
              return $this->collection->addNewColumn(new NewColumn($name, $type, $options));
          }

          return $this->collection->addColumn(new Column($name, $type, $options));
    }





    /**
     * @param string $name
     * @param array $options
     * @return DropColumn
    */
    public function dropColumn(string $name, array $options = []): DropColumn
    {
        return $this->collection->dropColumn(new DropColumn($name, $options));
    }


    /**
     * @param string $name
     * @return ModifyColumn
    */
    public function modifyColumn(string $name): ModifyColumn
    {
         return $this->collection->modifyColumn(new ModifyColumn($name));
    }





    /**
     * @param string $name
     * @param string $to
     * @return RenameColumn
    */
    public function renameColumn(string $name, string $to): RenameColumn
    {
         return $this->collection->renameColumn(new RenameColumn($name, $to));
    }




    /**
     * @return Column
    */
    public function id(): Column
    {
         return $this->increments('id');
    }





    /**
     * @inheritDoc
    */
    public function string(string $name, int $length = 255): Column
    {
        return $this->addColumn($name, "VARCHAR($length)");
    }




    /**
     * @inheritDoc
    */
    public function text(string $name): Column
    {
        return $this->addColumn($name, 'TEXT');
    }



    /**
     * @return void
    */
    public function timestamps(): void
    {
        $this->datetime('created_at');
        $this->datetime('updated_at');
    }




    /**
     * @inheritDoc
    */
    public function boolean(string $name): Column
    {
        return $this->addColumn($name, 'BOOLEAN');
    }





    /**
     * @return Column
    */
    public function softDeletes(): Column
    {
        return $this->boolean('deleted_at');
    }




    /**
     * @param $columns
     * @return $this
    */
    public function unique($columns): static
    {
          $this->collection->addUniques(new UniqueKey($columns));

          return $this;
    }





    /**
     * @param array|string $indexes
     * @return $this
    */
    public function index($indexes): static
    {
         $this->collection->addIndexes(new Index($indexes));

         return $this;
    }




    /**
     * @param string $name
     * @return ForeignKey
    */
    public function foreign(string $name): ForeignKey
    {
         $foreign = new ForeignKey($name);
         $foreign->constraintKey($this->foreignKeyName($name));
         return $this->collection->addForeignKey($foreign);
    }





    /**
     * @return ForeignKey
    */
    public function foreignId(): ForeignKey
    {
         return $this->foreign('id');
    }




    /**
     * @param string $name
     * @return string
    */
    public function foreignKeyName(string $name): string
    {
        return sprintf('fk_%s_%s', $this->table, $name);
    }




    /**
     * Determine if table exist
     *
     * @return bool
    */
    public function existTable(): bool
    {
        return in_array($this->getTable(), $this->showColumns());
    }





    /**
     * @return $this
    */
    public function createIndex(string $name): static
    {
          return $this;
    }




    /**
     * Create table
     *
     * @return bool
    */
    public function createTable(): bool
    {
        return $this->connection->exec(
            sprintf("CREATE TABLE IF NOT EXISTS %s (%s);",
                $this->getTable(),
                $this->collection->printCreateColumns()
            )
        );
    }





    /**
     * Update table
     *
     * @return bool
    */
    public function updateTable(): bool
    {
         return $this->connection->exec(
             sprintf('ALTER TABLE %s %s;', $this->getTable(), $this->collection->printUpdateColumns())
         );
    }




    /**
     * Drop Table
     *
     * @return bool
    */
    public function dropTable(): bool
    {
        return $this->connection->exec(sprintf('DROP TABLE %s;', $this->getTable()));
    }




    /**
     * @return bool
    */
    public function dropTableIfExists(): bool
    {
        return $this->connection->exec(sprintf('DROP TABLE IF EXISTS %s;', $this->getTable()));
    }




    /**
     * @return bool
    */
    public function dropTableCascade(): bool
    {
         return $this->connection->exec(sprintf('DROP TABLE %s CASCADE;', $this->getTable()));
    }





    /**
     * Truncate table
     *
     * @return bool
    */
    public function truncateTable(): bool
    {
         return $this->connection->exec(sprintf('TRUNCATE TABLE %s;', $this->getTable()));
    }





    /**
     * @return bool
    */
    public function truncateTableCascade(): bool
    {
         return $this->connection->exec(sprintf('TRUNCATE TABLE CASCADE %s;', $this->getTable()));
    }





    /**
     * @return array
    */
    public function showTables(): array
    {
         return $this->connection->showDatabaseTables();
    }





    /**
     * Show table columns
     *
     * @return array
    */
    abstract public function showColumns(): array;




    /**
     * Describe table
     *
     * @return mixed
    */
    abstract public function describeTable();
}