<?php
namespace Lexus\Component\Routing;


use Lexus\Component\Routing\Exception\BadControllerException;
use Lexus\Component\Routing\Exception\BadActionException;

class Route implements \ArrayAccess
{


       /**
        * Route domain
        *
        * @var string
       */
       protected $domain;



       /**
        * Route path
        *
        * @var string
       */
       protected $path;





       /**
        * Route name
        *
        * @var string
       */
       protected $name;





       /**
        * Route callback
        *
        * @var callable
       */
       protected $callback;



       /**
        * Route methods
        *
        * @var array
       */
       protected $methods = [];




      /**
       * Route controller
       *
       * @var array
      */
      protected $action = [
          'controller'  => '',
          'action' => ''
      ];




      /**
       * Route patterns
       *
       * @var array
      */
      protected $patterns = [];




      /**
       * Route matches params
       *
       * @var array
      */
      protected $matches = [];




      /**
       * Route middlewares
       *
       * @var array
      */
      protected $middlewares = [];



      /**
       * Route options
       *
       * @var array
      */
      protected $options = [];




      /**
       * @param array $methods
       * @param string $path
       * @param null $action
      */
      public function __construct(array $methods = [], string $path = '', $action = null)
      {
            $this->methods($methods);
            $this->path($path);
            $this->action($action);
      }




      /**
       * @param array $methods
       * @return $this
      */
      public function methods(array $methods): static
      {
          $this->methods = $methods;

          return $this;
      }




      /**
       * @param string $path
       * @return $this
      */
      public function path(string $path): static
      {
          $this->path = $path;

          return $this;
      }



      /**
       * @param $action
       * @return $this
      */
      public function action($action): static
      {
           if (is_callable($action)) {
               $this->callback($action);
           }elseif (is_array($action)) {
               $this->controller($action[0], $action[1] ?? '__invoke');
           }

           return $this;
      }




      /**
       * @return array
      */
      public function getMethods(): array
      {
          return $this->methods;
      }





      /**
       * @return string
      */
      public function getMethodsAsString(): string
      {
           return join('|', $this->methods);
      }




      /**
       * @return string
      */
      public function getPath(): string
      {
           return $this->path ?? '/';
      }




      /**
       * @return string|null
      */
      public function getName(): ?string
      {
           return $this->name;
      }




      /**
       * @return array
      */
      public function getPatterns(): array
      {
           return $this->patterns;
      }




      /**
       * @return array
      */
      public function getMiddlewares(): array
      {
          return $this->middlewares;
      }




      /**
       * @return array
      */
      public function getMatches(): array
      {
          return $this->matches;
      }




      /**
       * @param string $name
       * @param $default
       * @return mixed|null
      */
      public function getOption(string $name, $default = null): mixed
      {
            return $this->options[$name] ?? $default;
      }




      /**
       * @return array
      */
      public function getOptions(): array
      {
          return $this->options;
      }

      


      /**
       * @return string
      */
      public function getPattern(): string
      {
          $pattern = $this->getPath();
          
          if ($this->patterns) {
              foreach ($this->patterns as $k => $v) {
                  $pattern = preg_replace(["#{{$k}}#", "#{{$k}.?}#"], [$v, '?'. $v .'?'], $pattern);
              }
          }

          return '#^'. $this->resolvePattern($pattern) . '$#i';
      }





      /**
       * @return callable
      */
      public function getCallback(): callable
      {
           return $this->callback;
      }





      /**
       * @return string
      */
      public function getActionController(): string
      {
           return $this->action['controller'];
      }




      /**
       * @return string
      */
      public function getActionMethod(): string
      {
           return $this->action['action'];
      }




      /**
       * @return string
      */
      public function getDomain(): string
      {
           return $this->domain;
      }




      /**
       * @return string
       * @throws BadControllerException
      */
      public function getController(): string
      {
          if (! class_exists($controller = $this->getActionController())) {
              throw new BadControllerException($controller);
          }

          return $controller;
      }




      /**
       * @return string
       * @throws BadControllerException
      */
      public function getAction(): string
      {
          if (! method_exists($controller = $this->getController(), $action = $this->getActionMethod())) {
              throw new BadActionException("Method {$action} is not exist in controller {$controller}");
          }

          return $action;
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
       * @param callable $callback
       * @return $this
      */
      public function callback(callable $callback): static
      {
           $this->callback = $callback;

           return $this;
      }




      /**
       * @param string $controller
       * @param string $action
       * @return $this
      */
      public function controller(string $controller, string $action): static
      {
           $this->action = compact('controller', 'action');

           return $this;
      }




      /**
       * @param string $name
       * @return $this
      */
      public function name(string $name): static
      {
          $this->name .= $name;

          return $this;
      }




      /**
       * @param $middlewares
       * @return $this
      */
      public function middleware($middlewares): static
      {
           $this->middlewares = array_merge($this->middlewares, (array) $middlewares);

           return $this;
      }





      /**
       * @param string $name
       * @param $value
       * @return $this
      */
      public function withOption(string $name, $value): static
      {
           return $this->withOptions([$name => $value]);
      }




      /**
       * @param array $options
       * @return $this
      */
      public function withOptions(array $options): static
      {
           $this->options = array_merge($this->options, $options);

           return $this;
      }





      /**
       * @param string $name
       * @param string $regex
       * @return $this
      */
      public function where(string $name, string $regex): static
      {
           return $this->wheres([$name => $regex]);
      }





      /**
       * @param string $name
       * @return $this
      */
      public function whereNumber(string $name): self
      {
           return $this->where($name, '\d+');
      }






      /**
       * @param string $name
       * @return $this
      */
      public function whereText(string $name): self
      {
           return $this->where($name, '\w+');
      }




      /**
       * @param string $name
       * @return $this
      */
      public function whereAlphaNumeric(string $name): self
      {
          // [^a-z_\-0-9]
          return $this->where($name, '[^a-z_\-0-9]');
      }





       /**
        * @param string $name
        * @return $this
       */
       public function whereSlug(string $name): self
       {
           return $this->where($name, '[a-z\-0-9]+');
       }




       /**
        * @param string $name
        * @return $this
       */
       public function anything(string $name): self
       {
           return $this->where($name, '.*');
       }





      /**
       * @param array $patterns
       * @return $this
      */
      public function wheres(array $patterns): static
      {
          foreach ($patterns as $name => $regex) {
              $this->patterns[$name] = $this->makeRegex($name, $regex);
          }

          return $this;
      }


      /**
       * @return bool
      */
      public function callable(): bool
      {
           return is_callable($this->callback);
      }




      /**
       * @return mixed
      */
      public function call(): mixed
      {
          if (! $this->callable()) {
               return false;
          }

          return call_user_func_array($this->getCallback(), array_values($this->getMatches()));
      }



      /**
       * @param array $parameters
       * @return string
      */
      public function replaceParameters(array $parameters): string
      {
            $path = $this->getPath();

            foreach ($parameters as $k => $v) {
               $path = preg_replace(["#{{$k}}#", "#{{$k}.?}#"], [$v, $v], $path);
            }

            return $path;
      }





      /**
       * @param string $method
       * @param string $path
       * @return bool
      */
      public function match(string $method, string $path): bool
      {
            return $this->matchRequestMethod($method) && $this->matchRequestPath($path);
      }




      /**
       * @param string $requestMethod
       * @return bool
      */
      public function matchRequestMethod(string $requestMethod): bool
      {
           if (! in_array($requestMethod, $this->getMethods())) {
                $this->withOptions(compact('requestMethod'));
                return false;
           }

           return true;
      }




      /**
       * @param string $requestPath
       * @return bool
      */
      public function matchRequestPath(string $requestPath): bool
      {
            if (preg_match($pattern = $this->getPattern(), $this->resolveRequestPath($requestPath), $matches)) {
                $this->matches = $this->resolveMatches($matches);
                $this->withOptions(compact('pattern', 'requestPath'));
                return true;
            }

            return false;
      }




      /**
       * @return array
      */
      public function toArray(): array
      {
           return get_object_vars($this);
      }



      /**
       * @inheritDoc
      */
      public function offsetExists(mixed $offset): bool
      {
          return property_exists($this, $offset);
      }



      /**
       * @inheritDoc
      */
      public function offsetGet(mixed $offset): mixed
      {
           if (! $this->offsetExists($offset)) {
                return null;
           }

           return $this->{$offset};
      }



      /**
       * @inheritDoc
      */
      public function offsetSet(mixed $offset, mixed $value): void
      {
            if ($this->offsetExists($offset)) {
                 $this->{$offset} = $value;
            }
      }



     /**
      * @inheritDoc
     */
     public function offsetUnset(mixed $offset): void
     {
            unset($this->{$offset});
     }




     /**
      * @param string $name
      * @param string $regex
      * @return string
     */
     private function makeRegex(string $name, string $regex): string
     {
          return sprintf('(?P<%s>%s)', $name, str_replace('(', '(?:', $regex));
     }




     /**
      * @param array $matches
      * @return array
     */
     private function resolveMatches(array $matches): array
     {
         return array_filter($matches, function ($key) {
             return ! is_numeric($key);
         }, ARRAY_FILTER_USE_KEY);
     }




     /**
      * @param string $path
      * @return string
     */
     private function resolveRequestPath(string $path): string
     {
         return (string) parse_url($this->resolvePattern($path), PHP_URL_PATH);
     }



     /**
      * @param string $path
      * @return string
     */
     private function resolvePattern(string $path): string
     {
          return sprintf('/%s', trim($path, '\\/'));
     }
}