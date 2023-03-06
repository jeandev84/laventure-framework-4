<?php
namespace Laventure\Component\Database\Manager;

interface DatabaseManagerInterface
{

      /**
       * Connect to database
       *
       * @param string $name
       * @param array $credentials
       * @return mixed
      */
      public function connect($name, array $credentials);





      /**
       * Get connection to database
       *
       * @param string $name
       * @return mixed
      */
      public function connection($name = null);





      /**
       * Disconnect to database
       *
       * @param string $name
       * @return mixed
      */
      public function disconnect($name = null);




      /**
       * Reconnect to database
       *
       * @param string $name
       * @return mixed
      */
      public function reconnect($name = null);



      /**
       * Purge connection from database
       *
       * @param string $name
       * @return mixed
      */
      public function purge($name = null);
}