<?php
namespace Lexus\Component\Database\Schema\BluePrint\Drivers;

use Lexus\Component\Database\Schema\BluePrint\BluePrint;
use Lexus\Component\Database\Schema\BluePrint\Column\Column;


class MysqlBluePrint extends BluePrint
{


    /**
     * @inheritDoc
    */
    public function getTable(): string
    {
        return '`'. parent::getTable() .'`';
    }





    /**
     * @inheritDoc
    */
    public function showColumns(): array
    {

    }




    /**
     * @inheritDoc
    */
    public function describeTable()
    {

    }




    /**
     * @param string $name
     * @param string $type
     * @param array $options
     * @return Column
    */
    public function addColumn(string $name, string $type, array $options = []): Column
    {
        return parent::addColumn("`$name`", $type, $options);
    }




    /**
     * @inheritDoc
    */
    public function increments(string $name): Column
    {
        return $this->bigInteger($name)
                    ->primaryKey()
                    ->option('autoincrement', 'AUTO_INCREMENT');
    }




    /**
     * @inheritDoc
    */
    public function datetime(string $name): Column
    {
         return $this->addColumn($name, 'DATETIME');
    }



    /**
     * @inheritDoc
    */
    public function integer(string $name, int $length = 11): Column
    {
        return $this->addColumn($name, "INT($length)");
    }




    /**
     * @inheritDoc
    */
    public function smallInteger(string $name): Column
    {
        return $this->addColumn($name, 'SMALLINT');
    }





    /**
     * @inheritDoc
    */
    public function bigInteger(string $name): Column
    {
        return $this->addColumn($name, 'BIGINT');
    }
}