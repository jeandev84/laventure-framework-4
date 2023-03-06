<?php
namespace Laventure\Component\Database\Query\Builder;

interface SqlQueryBuilderInterface
{
    /**
     * Select records
     *
     * @param string $selects
     * @param string $table
     * @return mixed
    */
    public function selectQuery(string $selects, string $table);





    /**
     * Insert record
     *
     * @param array $attributes
     * @param string $table
     * @return mixed
    */
    public function insertQuery(array $attributes, string $table);





    /**
     * Update records
     *
     * @param array $attributes
     * @param string $table
     * @return mixed
    */
    public function updateQuery(array $attributes, string $table);






    /**
     * Delete records
     *
     * @param $table
     * @return mixed
    */
    public function deleteQuery($table);
}