<?php
namespace Laventure\Component\Database\Schema\Migration\Contract;

interface MigrationInterface
{

     /**
      * Get Migration name
      *
      * @return string
     */
     public function getName(): string;


     /**
      * Get Migration path
      *
      * @return string
     */
     public function getPath(): string;



     /**
      * Apply migrations
      *
      * @return mixed
     */
     public function up();




     /**
      * Revert migrations
      *
      * @return mixed
     */
     public function down();
}