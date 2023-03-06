<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager;

use Closure;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\NullConnection;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Contract\EntityManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Contract\PersistenceInterface;
use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
use Laventure\Component\Database\ORM\Mapper\Repository\NullEntityRepository;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;
use Laventure\Component\Database\Query\QueryBuilder;

class NullEntityManager implements EntityManagerInterface
{

    /**
     * @inheritDoc
    */
    public function registerClass($classname) {}


    /**
     * @inheritDoc
    */
    public function getMappedClass(): string
    {
        return "";
    }




    /**
     * @inheritDoc
    */
    public function getConnectionManager(): ConnectionInterface
    {
         return new NullConnection();
    }




    /**
     * @inheritDoc
     */
    public function getConnection()
    {
        return null;
    }



    /**
     * @inheritDoc
    */
    public function getRepository(string $classname): EntityRepositoryInterface
    {
         return new NullEntityRepository();
    }



    /**
     * @inheritDoc
    */
    public function statement(string $sql, array $params = []): QueryInterface
    {
         return (new NullConnection())->statement($sql, $params);
    }




    /**
     * @inheritDoc
    */
    public function unitOfWork(): PersistenceInterface
    {
         return new NullPersistence();
    }




    /**
     * @inheritDoc
    */
    public function createNativeQueryBuilder(): QueryBuilder
    {

    }




    /**
     * @inheritDoc
    */
    public function createQueryBuilder(): Select
    {

    }




    /**
     * @inheritDoc
     */
    public function flush()
    {

    }

    /**
     * @inheritDoc
     */
    public function beginTransaction()
    {

    }

    /**
     * @inheritDoc
     */
    public function commit()
    {

    }

    /**
     * @inheritDoc
     */
    public function rollback()
    {

    }

    /**
     * @inheritDoc
     */
    public function lastId(): int
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function transaction(Closure $closure)
    {

    }

    /**
     * @inheritDoc
     */
    public function persist(object $object)
    {

    }

    /**
     * @inheritDoc
     */
    public function remove(object $object)
    {

    }

    /**
     * @inheritDoc
     */
    public function attach(object $object)
    {

    }

    /**
     * @inheritDoc
     */
    public function detach(object $object)
    {

    }

    /**
     * @inheritDoc
    */
    public function attached(object $object): bool
    {
         return false;
    }
}