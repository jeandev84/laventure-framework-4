<?php
namespace Laventure\Component\Database\Schema;

use Closure;

interface SchemaInterface
{

     /**
      * @param string $table
      * @param Closure $closure
      * @return bool
     */
     public function create(string $table, Closure $closure): bool;




     /**
      * @param string $table
      * @param Closure $closure
      * @return bool
     */
     public function table(string $table, Closure $closure): bool;





     /**
      * Drop table
      *
      * @param string $table
      * @return bool
     */
     public function drop(string $table): bool;





     /**
      * Truncate table
      *
      * @param string $table
      * @return bool
     */
     public function truncate(string $table): bool;





     /**
      * Describe table
      *
      * @param string $table
      * @return mixed
     */
     public function describe(string $table): mixed;




     /**
      * Show table columns
      *
      * @param string $table
      * @return array
     */
     public function showColumns(string $table): array;





     /**
      * Show database tables
      *
      * @return array
     */
     public function showTables(): array;






     /**
      * Determine if table exist
      *
      * @param string $table
      * @return bool
     */
     public function exists(string $table): bool;





    /**
     * Transaction
     *
     * @param Closure $closure
     * @return bool
    */
    public function transaction(Closure $closure): bool;




    /**
     * Execute SQL
     *
     * @param string $sql
     * @return bool
    */
    public function exec(string $sql): bool;
}