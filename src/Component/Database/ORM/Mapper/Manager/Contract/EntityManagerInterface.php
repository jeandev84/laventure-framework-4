<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Contract;

use Closure;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Persistence;
use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\QueryBuilder;



interface EntityManagerInterface extends ObjectManager
{


     /**
      * Register class to map
      *
      * @param $classname
      * @return mixed
     */
     public function registerClass($classname);




     /**
      * Get mapped class
      *
      * @return string
     */
     public function getMappedClass(): string;





     /**
      * Get connection manager
      *
      * @return ConnectionInterface
     */
     public function getConnectionManager(): ConnectionInterface;




     /**
      * Get connection
      *
      * @return mixed
     */
     public function getConnection();




     /**
      * Get repository
      *
      * @param string $classname
      * @return EntityRepositoryInterface
     */
     public function getRepository(string $classname): EntityRepositoryInterface;





     /**
      * @param string $sql
      * @param array $params
      * @return QueryInterface
     */
     public function statement(string $sql, array $params = []): QueryInterface;




     /**
      * @return PersistenceInterface
     */
     public function getUnitOfWork(): PersistenceInterface;




     /**
      * Create native query builder
      *
      * @return QueryBuilder
     */
     public function createNativeQueryBuilder(): QueryBuilder;




     /**
      * Create select query
      *
      * @return Select
     */
     public function createQueryBuilder(): Select;


     



     /**
      * Flush changes
      *
      * @return mixed
     */
     public function flush();




     /**
      * @return mixed
     */
     public function beginTransaction();




     /**
      * @return mixed
     */
     public function commit();




     /**
      * @return mixed
     */
     public function rollback();




     /**
      * Get last insert id
      *
      * @return int
     */
     public function lastId(): int;




     /**
      * @param Closure $closure
      * @return mixed
     */
     public function transaction(Closure $closure);




     /**
      * @return mixed
     */
     public function clean();
}