<?php
namespace Laventure\Component\Routing\Contract;


interface RouterInterface
{


    /**
     * Determine if the current request method and path match route.
     *
     * @param string $requestMethod
     * @param string $requestPath
     * @return mixed
    */
    public function match($requestMethod, $requestPath);







    /**
     * Generate URI by given name
     *
     * @param $name
     * @param array $parameters
     * @return mixed
    */
    public function generate($name, $parameters = []);





    /**
     * Get route collection
     *
     * @return mixed
    */
    public function getRoutes();
}