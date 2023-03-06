<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Query;


use Laventure\Component\Database\ORM\Mapper\Manager\Contract\EntityManagerInterface;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Adapter\SelectQuery;


class Query extends SelectQuery
{


    /**
     * @var EntityManagerInterface
    */
    protected $em;




    /**
     * @param EntityManagerInterface $em
    */
    public function __construct(EntityManagerInterface $em)
    {
         parent::__construct($em->getMappedClass());
         $this->em = $em;
    }




    /**
     * @inheritDoc
    */
    public function getResult(): array
    {
        $this->persistResults($results = parent::getResult());

        return $results;
    }




    /**
     * @inheritDoc
    */
    public function getOneOrNullResult(): object|false
    {
        $this->persistResults([$object = parent::getOneOrNullResult()]);

        return $object;
    }



    /**
     * @param array $objects
     * @return void
    */
    private function persistResults(array $objects): void
    {
        foreach ($objects as $object) {
            if (is_object($object)) {
                $this->em->persist($object);
            }
        }
    }
}