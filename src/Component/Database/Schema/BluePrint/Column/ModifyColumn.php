<?php
namespace Laventure\Component\Database\Schema\BluePrint\Column;

class ModifyColumn extends Column
{

    /**
     * @inheritDoc
    */
    public function __construct(string $name)
    {
         parent::__construct($name, null);
    }



    /**
      * @inheritDoc
     */
     public function __toString(): string
     {
         $column[] = "MODIFY COLUMN";
         $column[] = parent::__toString();
         return join(' ', $column);
     }
}