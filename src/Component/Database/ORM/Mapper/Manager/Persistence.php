<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager;


use Laventure\Component\Database\ORM\Mapper\Collection\PersistenceCollection;
use Laventure\Component\Database\ORM\Mapper\Manager\Contract\EntityManagerInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Contract\PersistenceInterface;
use Laventure\Component\Database\ORM\Mapper\Manager\Query\Query;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Select;


class Persistence implements PersistenceInterface
{
      /**
       * @var string
      */
      protected $identity = 'id';




      /**
       * @var int
      */
      protected $index = 1;



      /**
       * @var EntityManagerInterface
      */
      protected $em;




      /**
       * @var DataMapper
      */
      protected $dataMapper;




      /**
       * @var array
      */
      protected $attached = [];



      /**
       * @var array[]
      */
      protected $persists = [];




      /**
       * @var array[]
      */
      protected $removes = [];




      /**
       * @param EntityManager $em
      */
      public function __construct(EntityManager $em)
      {
            $this->em          = $em;
            $this->dataMapper  = new DataMapper($em);
      }




      /**
       * @param object $object
       * @return void
      */
      public function attach(object $object)
      {
          $id = $this->generateId($object);
          $classname = $this->classname($object);

          $this->attached[$classname][$id] = $id;
     }




     /**
      * @param object $object
      * @return void
     */
     public function detach(object $object)
     {
         $id = $this->generateId($object);
         $classname = $this->classname($object);

         if ($this->attached($object)) {
            unset($this->attached[$classname][$id]);
         }
     }


     /**
      * @param object $object
      * @return bool
     */
     public function attached(object $object): bool
     {
         $id = $this->generateId($object);
         $classname = $this->classname($object);

         return isset($this->attached[$classname][$id]);
     }





      /**
       * @param string $column
       * @return $this
      */
      public function id(string $column): static
      {
          $this->identity = $column;

          return $this;
      }



      /**
       * @inheritDoc
      */
      public function generateId(object $object): int
      {
           $attributes = $this->dataMapper->map($object);

           if (isset($attributes[$this->identity])) {
                return $attributes[$this->identity];
           }

           $id = $this->index++;

           $this->setIdentity($object, $id);

           return $id;
      }




      /**
       * @return string
      */
      public function getIdentity(): string
      {
          return $this->identity;
      }



      /**
       * @param object $object
       * @param int $value
      * @return void
      */
      public function setIdentity(object $object,  int $value): void
      {
          // todo refactoring
          $reflection = new \ReflectionObject($object);
          foreach ($reflection->getProperties() as $property) {
             if ($property->getName() === $this->identity) {
                  $property->setValue($value);
              }
          }
    }



      /**
       * @inheritDoc
      */
      public function persist(object $object)
      {
           $attributes = $this->dataMapper->map($object);

           foreach ($attributes as $value) {
                if ($value instanceof PersistenceCollection) {
                     foreach ($value->toArray() as $item) {
                         $this->persists[$this->classname($item)][] = $this->dataMapper->map($item);
                     }
                }
           }

           unset($attributes[DataMapperResolver::PERSISTENCE]);

           $id = $this->generateId($object);

           $this->persists[$this->classname($object)][$id] = $attributes;

           $this->em->attach($object);

           return $this;
      }



      /**
       * @param object $object
       * @return string
      */
      public function classname(object $object): string
      {
           return get_class($object);
      }




      /**
       * @inheritDoc
      */
      public function remove(object $object)
      {
          $attributes = $this->dataMapper->map($object);

          if ($this->em->attached($object)) {
               $id = $this->generateId($object);
               unset($this->persists[$this->classname($object)][$id]);
          }

          if (isset($attributes[$this->identity])) {
              $this->removes[$this->classname($object)][] = $attributes;
          }

          return $this;
      }




      /**
       * @return void
      */
      public function save()
      {
          foreach ($this->persists as $classname => $items) {
              if (! empty($items)) {
                  foreach ($items as $attributes) {
                      $this->em->registerClass($classname);
                      if (! empty($attributes[$this->identity])) {
                          $this->update($this->removeIdFromArray($attributes), $this->criteria($attributes));
                      } else {
                          $this->insert($this->removeIdFromArray($attributes));
                      }
                  }
              }
          }
      }



      public function removes()
      {
          foreach ($this->removes as $classname => $items) {
               foreach ($items as $attributes) {
                   $this->em->registerClass($classname);
                   $this->delete($this->criteria($attributes));
               }
          }
      }



      /**
       * Transaction
       *
       * @return void
      */
      public function transaction(): void
      {
           $this->em->transaction(function () {
                $this->save();
                $this->removes();
           });
      }



     /**
      * @param string|null $select
      * @param array $criteria
      * @param array $orderBy
      * @return Select
     */
     public function select(string $select = null, array $criteria = [], array $orderBy = []): Select
     {
        $qb = $this->em->createNativeQueryBuilder()->select($select, $criteria);
        $qb->ordersBy($orderBy);
        $qb->setQuery(new Query($this->em));
        return $qb;
    }




    /**
     * @param $id
     * @return bool|object
    */
    public function find($id): object|bool
    {
         return $this->select(null, [$this->identity => $id])
                     ->getQuery()
                     ->getOneOrNullResult();
    }




    /**
     * @param array $attributes
     * @return int
    */
    public function insert(array $attributes): int
    {
        return $this->em->createNativeQueryBuilder()
                        ->insert($attributes)
                        ->execute();
    }




    /**
     * @param array $attributes
     * @param array $criteria
     * @return bool
    */
    public function update(array $attributes, array $criteria): bool
    {
        return $this->em->createNativeQueryBuilder()
                        ->update($attributes, $criteria)
                        ->execute();
    }





    /**
     * @param array $criteria
     * @return bool
    */
    public function delete(array $criteria): bool
    {
        return $this->em->createNativeQueryBuilder()
                        ->delete($criteria)
                        ->execute();
    }






    /**
       * @param array $attributes
       * @return array
      */
      private function removeIdFromArray(array $attributes): array
      {
           unset($attributes[$this->identity]);

           return $attributes;
      }




      /**
       * @param array $attributes
       * @return array
      */
      private function criteria(array $attributes): array
      {
            return [$this->identity => $attributes[$this->identity]];
      }
}