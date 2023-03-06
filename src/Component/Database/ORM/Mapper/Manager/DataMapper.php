<?php
namespace Lexus\Component\Database\ORM\Mapper\Manager;

use Lexus\Component\Database\ORM\Mapper\Collection\ArrayCollection;
use Lexus\Component\Database\ORM\Mapper\Collection\PersistenceCollection;
use Lexus\Component\Database\ORM\Mapper\DataMapperInterface;
use Lexus\Component\Database\ORM\Mapper\Manager\Exception\DataMapperException;


class DataMapper implements DataMapperInterface
{

      /**
       * @var EntityManager
      */
      protected $em;


      /**
       * @var DataMapperResolver
      */
      protected $dataMapperResolver;



      /**
       * @param EntityManager $em
      */
      public function __construct(EntityManager $em)
      {
           $this->em       = $em;
           $this->dataMapperResolver = new DataMapperResolver($em);
      }




      /**
       * @inheritDoc
      */
      public function map(object $object): array
      {
            if (! method_exists($object, 'getId')) {
                $this->abortIf(sprintf('Unable method getId() for [%s]', get_class($object)));
            }

            $attributes  = $this->mapAttributes($object);

            return $this->dataMapperResolver->resolve($attributes);
      }




      public function setAttributes(object $object, array $attributes)
      {
          $reflection = new \ReflectionObject($object);
          foreach ($reflection->getProperties() as $property) {
              if (isset($attributes[$property->getName()])) {
                  $property->setValue($attributes[$property->getName()]);
              }
          }
      }




      /**
       * @param object $object
       * @return array
      */
      public function mapAttributes(object $object): array
      {
          $reflection = new \ReflectionObject($object);

          $attributes = [];

          foreach ($reflection->getProperties() as $property) {

               $name  = $property->getName();
               $value = $property->getValue($object);
               $attributes[$name] = $this->dataMapperResolver->resolveValue($value);
          }

          return $attributes;
      }



      /**
       * @param string $message
       * @return mixed
      */
      private function abortIf(string $message)
      {
           (function () use ($message) {
               throw new DataMapperException($message);
           })();
      }
}