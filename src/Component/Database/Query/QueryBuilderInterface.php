<?php
namespace Laventure\Component\Database\Query;

use Laventure\Component\Database\Query\Builder\SQL\Commands\Delete;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Insert;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Update;


interface QueryBuilderInterface
{
    /**
     * @param string $selects
     * @param array $criteria
     * @return Select
    */
    public function select(string $selects, array $criteria = []): Select;




    /**
     * Insert attributes and return the last inserted id
     *
     * @param array $attributes
     * @return Insert
    */
    public function insert(array $attributes): Insert;





    /**
     * @param array $attributes
     * @param array $criteria
     * @return Update
    */
    public function update(array $attributes, array $criteria): Update;





    /**
     * @param array $criteria
     * @return Delete
    */
    public function delete(array $criteria): Delete;
}