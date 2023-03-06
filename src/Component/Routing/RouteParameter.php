<?php
namespace Lexus\Component\Routing;

class RouteParameter
{

     /**
      * @var string
     */
     protected $namespace = '';




     /**
      * @var RouteGroup
     */
     protected $routeGroup;





     public function __construct()
     {
          $this->routeGroup = new RouteGroup();
     }




     /**
      * @param RouteGroup $routeGroup
      * @return $this
     */
     public function setGroup(RouteGroup $routeGroup): static
     {
         $this->routeGroup = $routeGroup;

         return $this;
     }





     /**
      * @param string $namespace
      * @return $this
     */
     public function namespace(string $namespace): static
     {
          $this->namespace = $namespace;

          return $this;
     }




     /**
      * @param string $prefix
      * @return $this
     */
     public function prefix(string $prefix): static
     {
         $this->routeGroup->prefix($prefix);

         return $this;
     }




     /**
      * @param string $module
      * @return $this
     */
     public function module(string $module): static
     {
          $this->routeGroup->module($module);

          return $this;
     }




     /**
      * @param $middleware
      * @return $this
     */
     public function middleware($middleware): static
     {
          $this->routeGroup->middlewares($middleware);

          return $this;
     }




     /**
      * @param string $name
      * @return $this
     */
     public function name(string $name): static
     {
          $this->routeGroup->name($name);

          return $this;
     }





     /**
      * @param $methods
      * @return array
     */
     public function resolveMethods($methods): array
     {
         if (is_string($methods)) {
             $methods = explode('|', $methods);
         }

         return (array) $methods;
     }




     /**
      * @param string $path
      * @return string
     */
     public function resolvePath(string $path): string
     {
          if ($prefix = $this->routeGroup->getPrefix()) {
              $path = sprintf('%s/%s', $prefix, ltrim($path, '/'));
          }

          return $path;
     }




     /**
      * @param $action
      * @return mixed
     */
     public function resolveAction($action): mixed
     {
          if (is_string($action) && stripos($action, '@') !== false) {
              $action = explode('@', $action, 2);
              return [$this->getController($action[0]), $action[1]];
          }

          return $action;
     }



     /**
      * @param string $name
      * @return string
     */
     public function getController(string $name): string
     {
         $name = (string) str_replace($this->getNamespace(), '', $name);

         return sprintf('%s%s', $this->getNamespace(), $name);
     }





     /**
      * @return string
     */
     public function getNamespace(): string
     {
         if (! $this->namespace) {
             return '';
         }

         if ($module = $this->routeGroup->getModule()) {
             $this->namespace .= sprintf('\\%s', $module);
         }

         return sprintf('%s\\', $this->namespace);
     }




     /**
      * @return RouteGroup
     */
     public function getGroup(): RouteGroup
     {
          return $this->routeGroup;
     }

}