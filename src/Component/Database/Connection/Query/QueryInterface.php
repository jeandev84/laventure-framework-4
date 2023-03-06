<?php
namespace Lexus\Component\Database\Connection\Query;


interface QueryInterface
{

      /**
       * Prepare query
       *
       * @param string $sql
       * @param array $params
       * @return $this
      */
      public function prepare(string $sql, array $params = []): self;




      /**
       * Execute query
       *
       * @return mixed
      */
      public function execute();





      /**
       * @param string $sql
       * @return bool
      */
      public function executeSQL(string $sql): bool;




      /**
       * Mapping class
       *
       * @param string $classname
       * @return $this
      */
      public function map(string $classname): static;




      /**
       * Get last insert id
       *
       * @return int
      */
      public function lastInsertId(): int;




      /**
       * Fetch query data
       *
       * @return QueryResultInterface
      */
      public function fetch(): QueryResultInterface;
}