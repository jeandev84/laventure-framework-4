<?php
namespace Laventure\Component\Database\Connection\Query;

interface QueryLoggerInterface
{
      /**
       * @return array
      */
      public function getQueriesLog(): array;
}