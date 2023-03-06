<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager\Contract;


interface ObjectManager
{

    /**
     * @param object $object
     * @return mixed
    */
    public function persist(object $object);



    /**
     * @param object $object
     * @return mixed
    */
    public function remove(object $object);




    /**
     * @param object $object
     * @return mixed
    */
    public function attach(object $object);




    /**
     * @param object $object
     * @return mixed
    */
    public function detach(object $object);




    /**
     * @param object $object
     * @return bool
    */
    public function attached(object $object): bool;
}