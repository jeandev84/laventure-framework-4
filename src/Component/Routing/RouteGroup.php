<?php
namespace Lexus\Component\Routing;

use Closure;

class RouteGroup
{

    /**
     * @var array
    */
    protected $prefixes = [];


    /**
     * @var array
    */
    protected $modules  = [];




    /**
     * @var array
    */
    protected $names = [];




    /**
     * @var array
    */
    protected $middlewares = [];




    /**
     * @var Closure
    */
    protected $routes;





    public function __construct()
    {
        $this->routes = function () {};
    }




    /**
     * @param array $attributes
     * @return $this
    */
    public function attributes(array $attributes): static
    {
         foreach ($attributes as $name => $value) {
              if (is_callable([$this, $name])) {
                  call_user_func([$this, $name], $value);
              }
         }

         return $this;
    }




    /**
     * @param string $prefix
     * @return $this
    */
    public function prefix(string $prefix): static
    {
        $this->prefixes[] = trim($prefix, '\\/');

        return $this;
    }



    /**
     * @param string $module
     * @return $this
    */
    public function module(string $module): self
    {
        $this->modules[] = trim($module, '\\');

        return $this;
    }



    /**
     * @param string $name
     * @return $this
    */
    public function name(string $name): self
    {
        $this->names[] = $name;

        return $this;
    }




    /**
     * @param array $middlewares
     * @return $this
    */
    public function middlewares(array $middlewares): self
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);

        return $this;
    }



    /**
     * @param Closure $routes
     * @return $this
    */
    public function routes(Closure $routes): self
    {
        $this->routes = $routes;

        return $this;
    }



    /**
     * Map routes
     *
     * @param Router $router
     * @return void
    */
    public function map(Router $router): void
    {
         call_user_func($this->routes, $router);
    }




    /**
     * @return string
    */
    public function getPrefix(): string
    {
        return join('/', $this->prefixes);
    }




    /**
     * @return string
    */
    public function getModule(): string
    {
        return join('\\', $this->modules);
    }




    /**
     * @return string
    */
    public function getName(): string
    {
        return join($this->names);
    }




    /**
     * @return array
    */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }




    /**
     * @return void
    */
    public function removeAttributes(): void
    {
        $this->prefixes    = [];
        $this->modules     = [];
        $this->names       = [];
        $this->middlewares = [];
    }
}