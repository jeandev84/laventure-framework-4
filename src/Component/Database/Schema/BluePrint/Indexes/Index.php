<?php
namespace Lexus\Component\Database\Schema\BluePrint\Indexes;

use Lexus\Component\Database\Schema\BluePrint\PrintableInterface;

class Index implements PrintableInterface
{

    /**
     * @var array|string
    */
    protected $indexes = [];


    /**
     * @param $indexes
    */
    public function __construct($indexes)
    {
         $this->indexes = (array) $indexes;
    }




    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        return "INDEX(". join(',', $this->indexes) . ")";
    }
}