<?php
namespace Laventure\Component\Database\ORM\Mapper\Repository\Factory;

use Laventure\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;


abstract class EntityRepositoryFactory
{
    /**
     * @param string $class
     * @return EntityRepositoryInterface
     */
    abstract public function createRepository(string $class): EntityRepositoryInterface;
}