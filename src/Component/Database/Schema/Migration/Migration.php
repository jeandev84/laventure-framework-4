<?php
namespace Lexus\Component\Database\Schema\Migration;

use Lexus\Component\Database\Schema\Migration\Contract\MigrationInterface;
use ReflectionClass;

abstract class Migration implements MigrationInterface
{
      /**
       * @inheritDoc
      */
      public function getName(): string
      {
           return (new ReflectionClass(get_called_class()))->getShortName();
      }


      /**
       * @inheritDoc
      */
      public function getPath(): string
      {
          return (new ReflectionClass(get_called_class()))->getFileName();
      }

}