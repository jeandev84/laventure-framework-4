<?php
namespace Laventure\Component\Database\Schema\BluePrint\Keys;

use Laventure\Component\Database\Schema\BluePrint\PrintableInterface;


class ForeignKey implements PrintableInterface
{

     /**
      * @var string
     */
     protected $name;




     /**
      * @var string
     */
     protected $column;




     /**
      * @var string
     */
     protected $table;




     /**
      * @var string
     */
     protected $constraintKey;




     /**
      * @var Constrained
     */
     protected $constrained;




     /**
      * @param string $name
     */
     public function __construct(string $name)
     {
           $this->name = $name;
     }


     /**
      * @return string
     */
     public function getName(): string
     {
          return $this->name;
     }



     /**
      * @param string $constraintKey
      * @return $this
     */
     public function constraintKey(string $constraintKey): static
     {
          $this->constraintKey = $constraintKey;

          return $this;
     }




     /**
      * @param string $column
      * @return $this
     */
     public function references(string $column): static
     {
         $this->column = $column;

         return $this;
     }




     /**
      * @param string $table
      * @return Constrained
     */
     public function on(string $table): Constrained
     {
         $this->table = $table;

         return $this->constrained();
     }




     /**
      * @return Constrained
     */
     public function constrained(): Constrained
     {
          return $this->constrained = new Constrained();
     }





     /**
      * @inheritDoc
     */
     public function __toString(): string
     {
          $key = [];

          if ($this->constraintKey) {
              $key[] = "CONSTRAINT {$this->constraintKey}";
          }

          $key[] = sprintf('FOREIGN KEY (%s) REFERENCES %s(%s)', $this->name, $this->table, $this->column);

          $key[] = $this->constrained;

          return join(' ', $key);
     }
}