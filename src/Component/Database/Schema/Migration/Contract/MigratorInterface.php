<?php
namespace Laventure\Component\Database\Schema\Migration\Contract;

use Laventure\Component\Database\Schema\Migration\Migration;

interface MigratorInterface
{

      /**
        * Get migrations
        *
        * @return Migration[]
      */
      public function getMigrations(): array;




      /**
       * Get applied migrations
       *
       * @return array
      */
      public function getAppliedMigrations(): array;




      /**
       * Create migration version table
       *
       * @return bool
      */
      public function createTable(): bool;





      /**
       * Migrations to apply
       *
       * @return mixed
      */
      public function diff(): mixed;





      /**
       * Migrate all migrations to database
       *
       * @return bool
      */
      public function migrate(): bool;





      /**
       * Revert all applied migrations
       *
       * @return bool
      */
      public function rollback(): bool;





      /**
       * Reset all applied migrations
       *
       * @return bool
      */
      public function reset(): bool;





      /**
       * Refresh Migrations
       *
       * @return bool
      */
      public function refresh(): bool;
}