<?php
namespace Lexus\Component\Database\ORM\Mapper\Repository;

use Lexus\Component\Database\ORM\Mapper\Manager\Contract\EntityManagerInterface;
use Lexus\Component\Database\ORM\Mapper\Manager\EntityManager;
use Lexus\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Select;


class EntityRepository implements EntityRepositoryInterface
{

      /**
       * @var EntityManagerInterface
      */
      protected $em;



      /**
       * @param EntityManager $em
       * @param string $class
      */
      public function __construct(EntityManager $em, string $class)
      {
          $em->registerClass($class);
          $this->em = $em;
      }




      /**
       * @return string
      */
      protected function getTable(): string
      {
           return $this->em->getClassMapper()->getTableName();
      }




      /**
       * @param string $alias
       * @return Select
      */
      public function createQueryBuilder(string $alias): Select
      {
            return $this->em->createQueryBuilder()
                            ->from($this->getTable(), $alias);
      }



      /**
       * @inheritDoc
      */
      public function findAll()
      {
           return $this->em->createQueryBuilder()
                           ->getQuery()
                           ->getResult();
      }




      /**
       * @inheritDoc
      */
      public function find($id)
      {
           return $this->em->getUnitOfWork()->find($id);
      }




      /**
       * @inheritDoc
      */
      public function findBy(array $criteria, array $orderBy = [], $offset = null, $limit = null)
      {
           return $this->em->getUnitOfWork()
                           ->select(null, $criteria, $orderBy)
                           ->getQuery()
                           ->getResult();
      }




     /**
      * @inheritDoc
     */
     public function findOneBy(array $criteria)
     {
         return $this->em->getUnitOfWork()
                     ->select(null, $criteria)
                     ->getQuery()
                     ->getOneOrNullResult();
     }
}