<?php
namespace Laventure\Component\Database\Query;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Query\Builder\Builder;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Update;


class QueryBuilder implements QueryBuilderInterface
{

        /**
         * @var Builder
        */
        protected $builder;




        /**
         * @param ConnectionInterface $connection
         * @param string $table
        */
        public function __construct(ConnectionInterface $connection, string $table)
        {
             $this->builder = QueryBuilderFactory::make($connection, $table);
        }




       /**
        * @inheritDoc
       */
       public function select(string $selects = null, array $criteria = []): Select
       {
            return $this->builder->select($selects, $criteria);
       }




      /**
       * @inheritDoc
      */
      public function insert(array $attributes): Insert
      {
           return $this->builder->insert($attributes);
      }




      /**
       * @inheritDoc
      */
      public function update(array $attributes, array $criteria): Update
      {
           return $this->builder->update($attributes, $criteria);
      }





     /**
      * @inheritDoc
     */
     public function delete(array $criteria): Delete
     {
          return $this->builder->delete($criteria);
     }
}