<?php
namespace Laventure\Component\Database\Schema\BluePrint\Drivers;

use Laventure\Component\Database\Schema\BluePrint\BluePrint;
use Laventure\Component\Database\Schema\BluePrint\Column\Column;


class PgsqlBlueprint extends BluePrint
{


    /**
     * @inheritDoc
    */
    public function createTable(): bool
    {
        // TODO: Implement createTable() method.
    }




    /**
     * @inheritDoc
    */
    public function showColumns(): array
    {
         $columns = [];

         foreach ($this->describeTable() as $schema) {
              foreach ((array)$schema as $key => $value) {
                  $columns[$key][] = $value;
              }
         }

         return $columns;
    }




    /**
     * @inheritDoc
    */
    public function describeTable(): array
    {
         $this->createFunctionDescribeTable();

         $sql = sprintf("select  *  from describe_table('%s')", $this->getTable());

         return $this->connection->statement($sql)->fetch()->assoc();
    }



    /**
     * @inheritDoc
    */
    public function increments(string $name): Column
    {
         return $this->addColumn($name, 'SERIAL')->primaryKey();
    }



    /**
     * @inheritDoc
    */
    public function datetime(string $name): Column
    {
        return $this->addColumn($name, 'TIMESTAMP');
    }




    /**
     * @inheritDoc
    */
    public function integer(string $name, int $length = 11): Column
    {
        return $this->addColumn($name, 'INTEGER');
    }




    /**
     * @inheritDoc
     */
    public function smallInteger(string $name): Column
    {
        // TODO: Implement smallInteger() method.
    }



    /**
     * @inheritDoc
    */
    public function bigInteger(string $name): Column
    {
        // TODO: Implement bigInteger() method.
    }




    /**
     * @inheritDoc
    */
    public function dropTable(): bool
    {
        // TODO: Implement dropTable() method.
    }





    /**
     * @return bool
    */
    private function createFunctionDescribeTable(): bool
    {
        return $this->connection->exec(
            "create or replace function describe_table(tbl_name text) 
              returns table(column_name varchar, data_type varchar,character_maximum_length int) as $$
              select column_name, data_type, character_maximum_length
              from INFORMATION_SCHEMA.COLUMNS where table_name = $1;
              $$
              language 'sql';
            "
        );
    }
}