<?php
namespace Laventure\Component\Database\ORM\Mapper\Collection;

use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;
use Laventure\Component\Database\ORM\Mapper\Manager\Persistence;


class PersistenceCollection extends ArrayCollection
{

    /**
     * @var EntityManager
    */
    protected $entityManager;



    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}