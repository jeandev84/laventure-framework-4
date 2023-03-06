<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager;

use Laventure\Component\Database\ORM\Mapper\Manager\Contract\PersistenceInterface;

class NullPersistence implements PersistenceInterface
{

    /**
     * @inheritDoc
    */
    public function generateId(object $object): int
    {
        return 0;
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
}