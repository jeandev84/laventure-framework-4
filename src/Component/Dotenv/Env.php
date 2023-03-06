<?php
namespace Lexus\Component\Dotenv;

class Env
{


     /**
      * @param string $environment
     */
     public function __construct(string $environment)
     {
          $this->put($environment);
     }





     /**
       * @param string $environment
       * @return bool
      */
      public function put(string $environment): bool
      {
          if (preg_match('#^(?=[A-Z])(.*)=(.*)$#', $environment, $matches)) {

                $items = str_replace(' ', '', trim($matches[0]));
                list($key, $value) = explode("=", $items, 2);
                putenv($environment);
                $_SERVER[$key] = $_ENV[$key] = $value;
                return true;
          }

          return false;
      }




      /**
       * @param string $name
       * @return mixed
      */
      public function read(string $name): mixed
      {
           return getenv($name);
      }
}