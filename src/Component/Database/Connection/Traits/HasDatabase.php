<?php
namespace Lexus\Component\Database\Connection\Traits;

trait HasDatabase
{

     /**
      * @return string
     */
     public function getDatabase(): string
     {
          return "";
     }



     /**
      * @return array
     */
     public function showDatabases(): array
     {
          return [];
     }




     /**
      * @return bool
     */
     public function databaseExists(): bool
     {
          return in_array($this->getDatabase(), $this->showDatabases());
     }
}