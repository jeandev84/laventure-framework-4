<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository;


use Laventure\Component\Database\ORM\Mapper\Manager\EntityManager;

class ServiceRepository extends EntityRepository
{
      public function __construct(EntityManager $em, string $class)
      {
           parent::__construct($em, $class);
      }
}