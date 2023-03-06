<?php
namespace Lexus\Component\Database\ORM\Mapper\Collection;

use Lexus\Component\Database\ORM\Mapper\Manager\EntityManager;
use Lexus\Component\Database\ORM\Mapper\Manager\Persistence;


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