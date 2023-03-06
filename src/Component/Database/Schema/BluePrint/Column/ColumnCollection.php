<?php
namespace Lexus\Component\Database\Schema\BluePrint\Column;


use Lexus\Component\Database\Schema\BluePrint\Indexes\Index;
use Lexus\Component\Database\Schema\BluePrint\Keys\ForeignKey;
use Lexus\Component\Database\Schema\BluePrint\Keys\UniqueKey;


class ColumnCollection
{
     /**
      * @var Column[]
     */
     protected $columns = [];




     /**
      * @var object[]
     */
     protected $altered = [];



     /**
      * @var ForeignKey[]
     */
     protected $foreignKeys = [];




     /**
      * @var UniqueKey[]
     */
     protected $uniques = [];




     /**
      * @var Index[]
     */
     protected $indexes = [];





    /**
      * @param Column $column
      * @return Column
     */
     public function addColumn(Column $column): Column
     {
          return $this->columns[$column->getName()] = $column;
     }




     /**
      * @param NewColumn $column
      * @return NewColumn
     */
     public function addNewColumn(NewColumn $column): NewColumn
     {
          return $this->altered[$column->getName()] = $column;
     }




     /**
      * @param ModifyColumn $column
      * @return ModifyColumn
     */
     public function modifyColumn(ModifyColumn $column): ModifyColumn
     {
         return $this->altered[$column->getName()] = $column;
     }




     /**
      * @param RenameColumn $column
      * @return RenameColumn
     */
     public function renameColumn(RenameColumn $column): RenameColumn
     {
          return $this->altered[$column->getName()] = $column;
     }




     /**
      * @param DropColumn $column
      * @return DropColumn
     */
     public function dropColumn(DropColumn $column): DropColumn
     {
         return $this->altered[$column->getName()] = $column;
     }





     /**
      * @param ForeignKey $foreign
      * @return ForeignKey
     */
     public function addForeignKey(ForeignKey $foreign): ForeignKey
     {
          return $this->foreignKeys[$foreign->getName()] = $foreign;
     }





     /**
      * @param UniqueKey $uniques
      * @return $this
     */
     public function addUniques(UniqueKey $uniques)
     {
          $this->uniques[] = $uniques;

          return $this;
     }




     /**
      * @param Index $index
      * @return $this
     */
     public function addIndexes(Index $index): static
     {
          $this->indexes[] = $index;

          return $this;
     }




     /**
      * @return string
     */
     public function printCreateColumns(): string
     {
          $constraintColumns[] = join(", ", array_values($this->columns));
          $constraintColumns[] = join(", ", array_values($this->foreignKeys));
          $constraintColumns[] = join(", ", $this->uniques);
          $constraintColumns[] = join(", ", $this->indexes);

          return join($constraintColumns);
     }

     

     
     /**
      * @return string
     */
     public function printUpdateColumns(): string
     {
          return join(", ", array_values($this->altered));
     }
}