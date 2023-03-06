<?php
namespace Lexus\Component\Routing;

use Closure;
use Lexus\Component\Routing\Contract\RouteDispatcherInterface;
use Lexus\Component\Routing\Contract\RouterInterface;
use Lexus\Component\Routing\Exception\NotFoundException;
use Lexus\Component\Routing\Resource\Resource;


class Router implements RouterInterface
{

      /**
       * @var RouteCollection
      */
      protected $routes;



      /**
       * @var RouteDispatcherInterface
      */
      protected $dispatcher;




      /**
       * @var RouteFactory
      */
      protected $factory;




      /**
       * @var RouteParameter
      */
      protected $parameter;



      /**
       * @var string
      */
      protected $domain = '';




      /**
       * @var string
      */
      protected $namespace = '';




      /**
       * @var array
      */
      protected $patterns = [];




      /**
       * Router constructor.
       *
       * @param RouteDispatcherInterface|null $dispatcher
      */
      public function __construct(RouteDispatcherInterface $dispatcher = null)
      {
           $this->routes     = new RouteCollection();
           $this->factory    = new RouteFactory();
           $this->parameter  = new RouteParameter();
           $this->dispatcher = $dispatcher ?: new RouteDispatcher();
      }




      /**
       * @param string $domain
       * @return $this
      */
      public function domain(string $domain): static
      {
          $this->domain = $domain;

          return $this;
      }



      /**
       * @param string $namespace
       * @return $this
      */
      public function namespace(string $namespace): static
      {
          $this->parameter->namespace($namespace);

          return $this;
      }




      /**
       * @param array $patterns
       * @return $this
      */
      public function patterns(array $patterns): static
      {
          $this->patterns = $patterns;

          return $this;
      }



      /**
       * @param string $class
       * @return string
      */
      public function getController(string $class): string
      {
           return $this->parameter->getController($class);
      }





      /**
       * @param Route $route
       * @return Route
      */
      public function addRoute(Route $route): Route
      {
          return $this->routes->addRoute($route);
      }




      /**
       * @param RouteGroup $routeGroup
       * @return RouteGroup
      */
      public function addRouteGroup(RouteGroup $routeGroup): RouteGroup
      {
           $this->parameter->setGroup($routeGroup);

           $routeGroup->map($this);

           return $this->routes->addRouteGroup($routeGroup);
      }




      /**
       * @param Resource $resource
       * @return $this
      */
      public function addResource(Resource $resource): static
      {
           $resource->map($this);

           $this->routes->addResource($resource);

           return $this;
      }





      /**
       * @param $methods
       * @param $path
       * @param $action
       * @return Route
      */
      public function makeRoute($methods, $path, $action): Route
      {
          $route = $this->factory->createRoute(
              $this->parameter->resolveMethods($methods),
              $this->parameter->resolvePath($path),
              $this->parameter->resolveAction($action)
          );

          $route->domain($this->domain);
          $route->wheres($this->patterns);
          $route->name($this->parameter->getGroup()->getName());
          $route->middleware($this->parameter->getGroup()->getMiddlewares());

          return $route;
      }




      /**
       * Route middlewares
       *
       * @param array $middlewares
       * @return $this
      */
      public function middlewares(array $middlewares): static
      {
           return $this;
      }






      /**
       * Add Route group [prefix, module, name]
       *
       * @param array $attributes
       * @param Closure $routes
       * @return RouteGroup
      */
      public function group(array $attributes, Closure $routes): RouteGroup
      {
            return $this->addRouteGroup($this->factory->createRouteGroup($attributes, $routes));
      }




      /**
       * @param string $name
       * @param string $controller
       * @return $this
      */
      public function resource(string $name, string $controller): static
      {
            return $this->addResource($this->factory->createWebResource($name, $controller));
      }






      /**
       * @param array $resources
       * @return $this
      */
      public function resources(array $resources): static
      {
          foreach ($resources as $name => $controller) {
               $this->resource($name, $controller);
          }

          return $this;
      }




      /**
       * @param string $name
       * @param string $controller
       * @return $this
      */
      public function apiResource(string $name, string $controller): static
      {
           return $this->addResource($this->factory->createApiResource($name, $controller));
      }





      /**
       * @param array $resources
       * @return $this
      */
      public function apiResources(array $resources): static
      {
           foreach ($resources as $name => $controller) {
               $this->apiResource($name, $controller);
           }

           return $this;
      }




      /**
       * @param $methods
       * @param $path
       * @param $action
       * @return Route
      */
      public function map($methods, $path, $action): Route
      {
           return $this->addRoute($this->makeRoute($methods, $path, $action));
      }




      /**
       * @param $path
       * @param $action
       * @return Route
      */
      public function get($path, $action): Route
      {
           return $this->map(['GET'], $path, $action);
      }




      /**
       * @param $path
       * @param $action
       * @return Route
      */
      public function post($path, $action): Route
      {
          return $this->map(['POST'], $path, $action);
      }




      /**
       * @param $path
       * @param $action
       * @return Route
      */
      public function put($path, $action): Route
      {
          return $this->map(['PUT'], $path, $action);
      }




      /**
       * @param $path
       * @param $action
       * @return Route
      */
      public function delete($path, $action): Route
      {
          return $this->map(['DELETE'], $path, $action);
      }




      /**
       * @param $path
       * @param $action
       * @return Route
      */
      public function any($path, $action): Route
      {
           return $this->map(['GET|POST|PUT|DELETE'], $path, $action);
      }




      /**
       * @param array|string $middlewares
       * @return $this
      */
      public function middleware($middlewares): self
      {
          $this->parameter->middleware($middlewares);

          return $this;
      }




     /**
      * @param string $prefix
      * @return $this
     */
     public function prefix(string $prefix): self
     {
          $this->parameter->prefix($prefix);

          return $this;
     }




     /**
      * @param string $name
      * @return $this
     */
     public function name(string $name): self
     {
        $this->parameter->name($name);

        return $this;
     }




      /**
       * @param string $module
       * @return $this
      */
      public function module(string $module): self
      {
           $this->parameter->module($module);

           return $this;
      }




      /**
       * @return RouteCollection
      */
      public function collection(): RouteCollection
      {
           return $this->routes;
      }





      /**
       * @inheritDoc
       * @return Route|false
      */
      public function match($requestMethod, $requestPath): Route|bool
      {
           foreach ($this->getRoutes() as $route) {
               if ($route->match($requestMethod, $requestPath)) {
                    return $route;
               }
           }

           return false;
      }




      /**
       * @param $requestMethod
       * @param $requestPath
       * @return mixed
       * @throws NotFoundException
      */
      public function dispatchRoute($requestMethod, $requestPath): mixed
      {
             if (! $route = $this->match($requestMethod, $requestPath)) {
                 throw new NotFoundException("Route {$requestPath} not found.");
             }

             return $this->dispatcher->dispatchRoute($route);
      }





      /**
       * @param string $name
       * @return bool
      */
      public function remove(string $name): bool
      {
           return $this->routes->removeRouteByName($name);
      }




      /**
       * @inheritDoc
      */
      public function generate($name, $parameters = []): string
      {
           return $this->routes->getPath($name, $parameters);
      }




      /**
       * @inheritDoc
      */
      public function getRoutes()
      {
          return $this->routes->getRoutes();
      }
}