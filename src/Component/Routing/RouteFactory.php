<?php
namespace Laventure\Component\Routing;

use Closure;
use Laventure\Component\Routing\Resource\ApiResource;
use Laventure\Component\Routing\Resource\Resource;
use Laventure\Component\Routing\Resource\ResourceType;
use Laventure\Component\Routing\Resource\WebResource;

class RouteFactory
{

     /**
      * @param $methods
      * @param $path
      * @param $action
      * @return Route
     */
     public function createRoute($methods, $path, $action): Route
     {
           return new Route($methods, $path, $action);
     }




     /**
      * @param array $attributes
      * @param Closure $closure
      * @return RouteGroup
     */
     public function createRouteGroup(array $attributes, Closure $closure): RouteGroup
     {
           $routeGroup = new RouteGroup();
           $routeGroup->attributes($attributes);
           $routeGroup->routes($closure);
           return $routeGroup;
     }



     /**
      * @param string $name
      * @param string $controller
      * @return WebResource
     */
     public function createWebResource(string $name, string $controller): WebResource
     {
          return new WebResource($name, $controller);
     }




     /**
      * @param string $name
      * @param string $controller
      * @return ApiResource
     */
     public function createApiResource(string $name, string $controller): ApiResource
     {
          return new ApiResource($name, $controller);
     }
}