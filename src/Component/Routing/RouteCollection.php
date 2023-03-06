<?php
namespace Lexus\Component\Routing;

use Lexus\Component\Routing\Resource\Resource;


class RouteCollection
{

      /**
       * @var Route[]
      */
      protected $routes = [];



      /**
       * @var Route[]
      */
      protected $controllers = [];



      /**
       * @var Route[]
      */
      protected $methods = [];




      /**
       * @var Route[]
      */
      protected $names = [];




      /**
       * Route groups
       *
       * @var RouteGroup[]
      */
      protected $groups = [];




      /**
       * Route Resources
       *
       * @var array
      */
      protected $resources = [];



      /**
       * Add route
       *
       * @param Route $route
       * @return Route
      */
      public function addRoute(Route $route): Route
      {
           $this->methods[$route->getMethodsAsString()][$route->getPath()] = $route;

           if ($controller = $route->getActionController()) {
               $this->controllers[$controller][$route->getPath()] = $route;
           }

           return $this->routes[] = $route;
      }




      /**
       * @param RouteGroup $routeGroup
       * @return RouteGroup
      */
      public function addRouteGroup(RouteGroup $routeGroup): RouteGroup
      {
            $this->groups[] = $routeGroup;

            $routeGroup->removeAttributes();

            return $routeGroup;
      }




      /**
       * @param Resource $resource
       * @return Resource
      */
      public function addResource(Resource $resource): Resource
      {
            $resourceType = $resource->getResourceType();
            $resourceName = $resource->getName();

            $this->resources[$resourceType][$resourceName] = $resource;

            return $resource;
      }




      /**
       * @param Route $route
       * @return bool
      */
      public function removeRoute(Route $route): bool
      {
           $key = array_search($route, $this->routes);

           if ($controller = $route->getActionController()) {
               unset($this->controllers[$controller][$route->getPath()]);
           }

           if ($name = $route->getName()) {
               unset($this->names[$name]);
           }

           unset($this->methods[$route->getMethodsAsString()][$route->getPath()], $this->routes[$key]);

           return true;
      }




      /**
       * @param string $name
       * @return bool
      */
      public function removeRouteByName(string $name): bool
      {
           if (! isset($this->names[$name])) {
                return false;
           }

           return $this->removeRoute($this->names[$name]);
      }




      /**
       * Get routes by name
       *
       * @return Route[]
      */
      public function getNames(): array
      {
          foreach ($this->routes as $route) {
              if ($name = $route->getName()) {
                  $this->names[$name] = $route;
              }
          }

          return $this->names;
      }




      /**
       * Get routes by method
       *
       * @return Route[]
      */
      public function getMethods(): array
      {
           return $this->methods;
      }




      /**
       * Get routes by controller
       *
       * @return Route[]
      */
      public function getControllers(): array
      {
           return $this->controllers;
      }




      /**
       * @param string $name
       * @param array $parameters
       * @return string
      */
      public function getPath(string $name, array $parameters = []): string
      {
          if (! array_key_exists($name, $this->getNames())) {
              return "";
          }

          return $this->names[$name]->replaceParameters($parameters);
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
      * Get route groups
      *
      * @return RouteGroup[]
     */
     public function getGroups(): array
     {
        return $this->groups;
     }




    /**
     * @return Resource[]
    */
    public function getResources(): array
    {
        return $this->resources;
    }
}