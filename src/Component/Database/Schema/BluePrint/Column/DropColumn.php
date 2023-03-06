<?php
namespace Laventure\Component\Database\Schema\BluePrint\Column;

class DropColumn extends Column
{


      /**
       * @inheritDoc
      */
      public function __construct(string $name, array $options = [])
      {
          parent::__construct($name, null, $options);
      }




      /**
       * @inheritDoc
      */
      public function __toString(): string
      {
          $column[] = "DROP COLUMN";
          $column[] = parent::__toString();
          return join(' ', $column);
      }
}