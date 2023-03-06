<?php
namespace Laventure\Component\Database\ORM\Mapper\Manager;

class ClassMapper
{

     /**
      * @var string
     */
     private $classname;



     /**
      * @var string
     */
     private $table;




     /**
      * @param string|null $classname
     */
     public function __construct(string $classname = null)
     {
          if ($classname) {
              $this->map($classname);
          }
     }




     /**
      * @param string $classname
      * @return $this
     */
     public function map(string $classname): static
     {
          $this->classname = $classname;

          return $this;
     }




     /**
      * @param string $table
      * @return $this
     */
     public function table(string $table): static
     {
         $this->table = $table;

         return $this;
     }




     /**
      * @return string
     */
     public function getClassname(): string
     {
          return $this->classname;
     }




     /**
      * @return string
     */
     public function getTableName(): string
     {
         if ($this->table) {
             return $this->table;
         }

         return (function () {
             $shortname = (new \ReflectionClass($this->getClassname()))->getShortName();
             return mb_strtolower($shortname);
         })();
     }
}