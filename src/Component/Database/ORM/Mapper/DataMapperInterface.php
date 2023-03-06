<?php
namespace Laventure\Component\Database\ORM\Mapper;

interface DataMapperInterface
{
    /**
     * Map object attributes
     *
     * @param object $object
     * @return array
    */
    public function map(object $object): array;
}