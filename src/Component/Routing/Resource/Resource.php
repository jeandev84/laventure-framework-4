<?php
namespace Laventure\Component\Routing\Resource;

use Laventure\Component\Routing\Route;
use Laventure\Component\Routing\Router;

abstract class Resource
{

    /**
     * Resource name
     *
     * @var string
    */
    protected $name;



    /**
     * Resource controller
     *
     * @var string
    */
    protected $controller;




    /**
     * Routes
     *
     * @var Route[]
    */
    protected $routes = [];




    /**
     * @param string $name
     * @param string $controller
    */
    public function __construct(string $name, string $controller)
    {
         $this->name = $name;
         $this->controller = $controller;
    }




    /**
     * Get name
     *
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }



    /**
     * Get controller
     *
     * @return string
    */
    public function getController(): string
    {
        return $this->controller;
    }




    /**
     * @param Router $router
     * @return void
    */
    public function map(Router $router): void
    {
       foreach (static::configureRoutes() as $route) {

           $action = [$router->getController($this->controller), $route['action']];
           
           $this->routes[] = $router->map($route['methods'], $this->resolvePath($route['path']), $action)
                                    ->name($route['action'])
                                    ->whereNumber('id');
       }
    }




    /**
     * Get routes
     *
     * @return Route[]
    */
    public function getRoutes(): array
    {
        return $this->routes;
    }


    /**
     * @param string $path
     * @return string
    */
    private function resolvePath(string $path): string
    {
        return (string) preg_replace('#{param}#', '{id}', $path);;
    }



    /**
     * Get route configs
     *
     * @return array
    */
    abstract protected static function configureRoutes(): array;




    /**
     * Get resource type
     *
     * @return string
    */
    abstract public function getResourceType(): string;
}