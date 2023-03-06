<?php
namespace Lexus\Component\Database\ORM\Mapper\Manager\Contract;

interface PersistenceInterface
{

     /**
      * Generate ID
      *
      * @param object $object
      * @return int
     */
     public function generateId(object $object): int;




     /**
      * @param object $object
      * @return mixed
     */
     public function persist(object $object);





     /**
      * @param object $object
      * @return mixed
     */
     public function remove(object $object);
}