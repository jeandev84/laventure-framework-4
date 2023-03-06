<?php
namespace Laventure\Component\Database\Schema\BluePrint\Drivers;

use Laventure\Component\Database\Schema\BluePrint\BluePrint;
use Laventure\Component\Database\Schema\BluePrint\Column\Column;

class OracleBluePrint extends BluePrint
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
        // TODO: Implement showColumns() method.
    }

    /**
     * @inheritDoc
     */
    public function describeTable()
    {
        // TODO: Implement describeTable() method.
    }

    /**
     * @inheritDoc
     */
    public function increments(string $name): Column
    {
        // TODO: Implement increments() method.
    }

    /**
     * @inheritDoc
     */
    public function string(string $name, int $length = 255): Column
    {
        // TODO: Implement string() method.
    }

    /**
     * @inheritDoc
     */
    public function text(string $name): Column
    {
        // TODO: Implement text() method.
    }

    /**
     * @inheritDoc
     */
    public function datetime(string $name): Column
    {
        // TODO: Implement datetime() method.
    }

    /**
     * @inheritDoc
     */
    public function boolean(string $name): Column
    {
        // TODO: Implement boolean() method.
    }

    /**
     * @inheritDoc
     */
    public function integer(string $name, int $length = 11): Column
    {
        // TODO: Implement integer() method.
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
}