<?php
namespace Lexus\Component\Database\ORM\Mapper\Repository\Factory;

use Lexus\Component\Database\ORM\Mapper\Repository\Contract\EntityRepositoryInterface;


abstract class EntityRepositoryFactory
{
    /**
     * @param string $class
     * @return EntityRepositoryInterface
     */
    abstract public function createRepository(string $class): EntityRepositoryInterface;
}