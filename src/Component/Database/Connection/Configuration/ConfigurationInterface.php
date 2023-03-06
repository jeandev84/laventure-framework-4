<?php
namespace Laventure\Component\Database\Connection\Configuration;

interface ConfigurationInterface
{


    /**
     * @return mixed
    */
    public function getDatabase();


    /**
     * @return mixed
    */
    public function getUsername();



    /**
     * @return mixed
    */
    public function getPassword();




    /**
     * @return mixed
    */
    public function getHost();
}