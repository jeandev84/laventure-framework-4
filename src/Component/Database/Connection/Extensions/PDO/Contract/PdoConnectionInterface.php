<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO\Contract;

use PDO;

interface PdoConnectionInterface
{
      /**
       * @return PDO
      */
      public function getPdo(): PDO;
}