<?php
namespace Lexus\Component\Database\ORM\Mapper\Repository;

use Lexus\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;

class NullEntityRepository implements EntityRepositoryInterface
{

    /**
     * @inheritDoc
    */
    public function findAll()
    {
        return [];
    }



    /**
     * @inheritDoc
    */
    public function find($id)
    {
        return null;
    }




    /**
     * @inheritDoc
    */
    public function findBy(array $criteria, array $orderBy = [], $offset = null, $limit = null)
    {
         return [];
    }



    /**
     * @inheritDoc
    */
    public function findOneBy(array $criteria)
    {
         return null;
    }
}