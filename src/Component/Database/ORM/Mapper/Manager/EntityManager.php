<?php
namespace Lexus\Component\Database\ORM\Mapper\Manager;


use Closure;
use Exception;
use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\Query\QueryInterface;
use Lexus\Component\Database\ORM\Mapper\Manager\Contract\EntityManagerInterface;
use Lexus\Component\Database\ORM\Mapper\Manager\Contract\PersistenceInterface;
use Lexus\Component\Database\ORM\Mapper\Manager\Exception\EntityManagerException;
use Lexus\Component\Database\ORM\Mapper\Repository\Factory\EntityRepositoryFactory;
use Lexus\Component\Database\ORM\Mapper\Repository\ServiceRepository;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Select;
use Lexus\Component\Database\Query\QueryBuilder;

class EntityManager implements EntityManagerInterface
{


    /**
     * @var ConnectionInterface
    */
    protected $connection;




    /**
     * @var EntityRepositoryFactory
    */
    protected $repositoryFactory;




    /**
     * @var EventManager
    */
    protected $eventManager;



    /**
     * @var PersistenceInterface
    */
    protected $persistence;




    /**
     * @var ClassMapper
    */
    protected $classMapper;




    /**
     * @param ConnectionInterface $connection
     * @param EntityRepositoryFactory $repositoryFactory
    */
    public function __construct(ConnectionInterface $connection, EntityRepositoryFactory $repositoryFactory)
    {
         $this->connection        = $connection;
         $this->repositoryFactory = $repositoryFactory;
         $this->persistence       = new Persistence($this);
         $this->classMapper       = new ClassMapper();
    }



    /**
     * @inheritDoc
    */
    public function getConnectionManager(): ConnectionInterface
    {
        return $this->connection;
    }




    /**
     * @inheritDoc
    */
    public function registerClass($classname)
    {
         $this->classMapper->map(is_object($classname) ? get_class($classname) : $classname);
    }



    /**
     * @inheritDoc
    */
    public function getMappedClass(): string
    {
        return $this->classMapper->getClassname();
    }




    /**
     * @return ClassMapper
    */
    public function getClassMapper(): ClassMapper
    {
        return $this->classMapper;
    }




    /**
     * @return Persistence
    */
    public function getUnitOfWork(): Persistence
    {
        return $this->persistence;
    }




    /**
     * @inheritDoc
    */
    public function getConnection()
    {
         return $this->connection->getConnection();
    }



    /**
     * @inheritDoc
    */
    public function getRepository(string $classname): ServiceRepository
    {
         return $this->repositoryFactory->createRepository($classname);
    }




    /**
     * @inheritDoc
    */
    public function statement(string $sql, array $params = []): QueryInterface
    {
         return $this->connection->statement($sql, $params);
    }


    /**
     * @inheritDoc
    */
    public function createNativeQueryBuilder(): QueryBuilder
    {
         return new QueryBuilder($this->connection, $this->classMapper->getTableName());
    }




    /**
     * @return Select
    */
    public function createQueryBuilder(): Select
    {
         return $this->persistence->select();
    }




    /**
     * @inheritDoc
    */
    public function persist(object $object)
    {
         $this->persistence->persist($object);
    }



    /**
     * @inheritDoc
    */
    public function remove(object $object)
    {
         $this->persistence->remove($object);
    }



    /**
     * @inheritDoc
    */
    public function attach(object $object)
    {
        $this->persistence->attach($object);
    }




    /**
     * @inheritDoc
    */
    public function detach(object $object)
    {
        $this->persistence->detach($object);
    }




    /**
     * @inheritDoc
    */
    public function attached(object $object): bool
    {
         return $this->persistence->attached($object);
    }




    /**
     * @inheritDoc
    */
    public function flush()
    {
        $this->persistence->transaction();
    }




    /**
     * @inheritDoc
    */
    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }




    /**
     * @inheritDoc
    */
    public function commit()
    {
        $this->connection->commit();
    }




    /**
     * @inheritDoc
    */
    public function rollback()
    {
        $this->connection->rollback();
    }




    /**
     * @inheritDoc
    */
    public function lastId(): int
    {
        return $this->connection->lastInsertId();
    }




    /**
     * @inheritDoc
    */
    public function transaction(Closure $closure)
    {
        try {

            $this->beginTransaction();

            $closure($this);

            $this->commit();

        } catch (Exception $exception) {

            $this->rollback();

            $this->abortIf($exception);
        }
    }




    /**
     * @param string|null $select
     * @param array $criteria
     * @param array $orderBy
     * @return array
    */
    public function findBy(string $select = null, array $criteria = [], array $orderBy = []): array
    {
        return $this->persistence->select($select, $criteria, $orderBy)->getQuery()->getResult();
    }




    /**
     * @return array
    */
    public function logQueries(): array
    {
         return $this->connection->getQueriesLog();
    }



    /**
     * @inheritDoc
    */
    public function clean()
    {
        $this->connection->disconnect();
        $this->connection = null;
        $this->repositoryFactory = null;
        $this->persistence = null;
        $this->classMapper = null;
    }




    /**
     * @param Exception $exception
     * @return void
    */
    private function abortIf(Exception $exception): void
    {
         (function () use ($exception) {
             throw new EntityManagerException($exception->getMessage());
         })();
    }
}