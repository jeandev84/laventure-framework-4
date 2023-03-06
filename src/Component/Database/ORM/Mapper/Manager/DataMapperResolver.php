<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager;


use Laventure\Component\Database\ORM\Mapper\Collection\ArrayCollection;
use Laventure\Component\Database\ORM\Mapper\Collection\PersistenceCollection;

class DataMapperResolver
{


       const PERSISTENCE = '__persistence__';


      /**
       * @var EntityManager
      */
      protected $em;



      /**
       * @param EntityManager $em
      */
      public function __construct(EntityManager $em)
      {
           $this->em = $em;
      }



      /**
       * @param $value
       * @return mixed
      */
      public function resolveValue($value): mixed
      {
          if ($value instanceof \DateTimeInterface) {
              return $value->format('Y-m-d H:i:s');
          }

          return $value;
      }


      public function resolve(array $attributes)
      {
          $persistence = new PersistenceCollection($this->em);

          foreach ($attributes as $column => $value) {
              if ($value instanceof ArrayCollection) {
                  foreach ($value->toArray() as $object) {
                      $persistence->add($object);
                      unset($attributes[$column]);
                  }
              } elseif (is_object($value)) {
                  $persistence->add($value);
                  unset($attributes[$column]);
              }
          }

          if (! $persistence->isEmpty()) {
              $attributes[static::PERSISTENCE] = $persistence;
          }

          return $attributes;
      }
}