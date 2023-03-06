<?php
namespace Laventure\Component\Database\Schema\BluePrint\Keys;

use Laventure\Component\Database\Schema\BluePrint\PrintableInterface;

class UniqueKey implements PrintableInterface
{

    /**
     * @var array|string
    */
    protected $columns = [];



    /**
     * @param array|string $columns
    */
    public function __construct($columns)
    {
        $this->columns = (array) $columns;
    }



    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
         return "UNIQUE(". join(',', $this->columns) . ")";
    }
}