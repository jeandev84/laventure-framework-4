<?php
namespace Lexus\Component\Database\Query\Builder\Extensions;


use Lexus\Component\Database\Connection\Extensions\PDO\PdoConnection;
use Lexus\Component\Database\Query\Builder\Builder;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Delete;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Insert;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Select;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Update;

class PdoQueryBuilder extends Builder
{
      /**
       * @param PdoConnection $connection
       * @param string $table
      */
      public function __construct(PdoConnection $connection, string $table)
      {
          parent::__construct($connection, $table);
      }




      /**
       * @inheritDoc
      */
      public function select(string $selects = null, array $wheres = []): Select
      {
           $command = parent::select($selects, $this->bindConditions($wheres));
           $command->setParameters($wheres);
           return $command;
      }




      /**
       * @inheritDoc
      */
      public function insert(array $attributes): Insert
      {
           $command = parent::insert($attributes);

           if ($command->isMultiple()) {
              [$bindings, $parameters] = $this->bindMultipleAttributes($command->getAttributes());
              $command->addMultiple($bindings);
              $command->setParameters($parameters);
           } else {
              [$bindings, $parameters] = $this->bindAttributes($command->getAttributes());
              $command->add($bindings);
              $command->setParameters($parameters);
           }

           return $command;
      }



      /**
       * @inheritDoc
      */
      public function update(array $attributes, array $wheres): Update
      {
           [$bindings, $parameters] = $this->bindAttributes($attributes);
           $command = parent::update($bindings, $this->bindConditions($wheres));
           $command->setParameters(array_merge($parameters, $wheres));
           return $command;
      }



     /**
      * @inheritDoc
     */
     public function delete(array $wheres): Delete
     {
         $command = parent::delete($this->bindConditions($wheres));
         $command->setParameters($wheres);
         return $command;
     }




     /**
      * @param array $wheres
      * @return array
     */
     private function bindConditions(array $wheres): array
     {
          $bindings = [];

          foreach (array_keys($wheres) as $column) {
              $bindings[] = "$column = :{$column}";
          }

          return $bindings;
     }



     /**
      * @param array $attributes
      * @return array
     */
     private function bindAttributes(array $attributes): array
     {
          $bindings = [];
          foreach ($attributes as $column => $value) {
              $bindings[$column] = ":$column";
          }

          return [$bindings, $attributes];
     }





     /**
      * @param array $attributes
      * @return array
     */
     private function bindMultipleAttributes(array $attributes): array
     {
         $i = 0;
         $bindings   = [];
         $parameters = [];

         foreach ($attributes as $index => $params) {
             foreach ($params as $column => $value) {
                 $bindParameter = "{$column}_{$i}";
                 $bindings[$index][$column] = ":$bindParameter";
                 $parameters[$bindParameter] = $value;
             }
             $i++;
         }

         return [$bindings, $parameters];
     }
}