<?php
namespace Lexus\Component\Database\Schema\Migration;

class MigrationCollection
{

     /**
      * @var Migration[]
     */
     protected $migrations = [];



     /**
      * @param Migration $migration
      * @return $this
     */
     public function add(Migration $migration): static
     {
         $this->migrations[$migration->getName()] = $migration;

         return $this;
     }




     /**
      * @return Migration[]
     */
     public function getMigrations(): array
     {
          return $this->migrations;
     }
}