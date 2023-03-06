<?php
namespace Lexus\Component\Database\Schema\BluePrint\Keys;

use Lexus\Component\Database\Schema\BluePrint\PrintableInterface;


class PrimaryKey implements PrintableInterface
{

     /**
      * @var array
     */
     protected $columns = [];



     /**
      * @param $columns
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
         return "PRIMARY KEY (". join(',', $this->columns) . ")";
     }
}