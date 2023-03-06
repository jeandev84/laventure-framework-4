<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository\Contract;

interface EntityRepositoryInterface
{

      /**
       * @return mixed
      */
      public function findAll();


      /**
       * @param $id
       * @return mixed
      */
      public function find($id);




      /**
       * @param array $criteria
       * @param array $orderBy
       * @param null $offset
       * @param null $limit
       * @return mixed
      */
      public function findBy(array $criteria, array $orderBy = [], $offset = null, $limit = null);




      /**
       * @param array $criteria
       * @return mixed
      */
      public function findOneBy(array $criteria);
}