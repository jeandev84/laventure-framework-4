<?php
namespace Laventure\Component\Database\Query\Builder;

use Laventure\Component\Database\Query\Builder\SQL\Commands\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Update;

interface BuilderInterface
{
     /**
      * @param string $selects
      * @param array $wheres
      * @return Select
     */
     public function select(string $selects, array $wheres = []): Select;



     /**
      * @param array $attributes
      * @return Insert
     */
     public function insert(array $attributes): Insert;




     /**
      * @param array $attributes
      * @param array $wheres
      * @return Update
     */
     public function update(array $attributes, array $wheres): Update;




     /**
      * @param array $wheres
      * @return Delete
     */
     public function delete(array $wheres): Delete;
}