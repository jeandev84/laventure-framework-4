<?php
namespace Lexus\Component\Database\Schema\BluePrint\Column\Contract;

use Lexus\Component\Database\Schema\BluePrint\PrintableInterface;

interface ColumnInterface extends PrintableInterface
{

     /**
      * Get column name
      *
      * @return string
     */
     public function getName(): string;



     /**
      * Get column type
      *
      * @return string
     */
     public function getType(): string;




     /**
      * Get column options
      *
      * @return array
     */
     public function getOptions(): array;




     /**
      * @return $this
     */
     public function unique(): static;




     /**
      * Set column nullable
      *
      * @return mixed
     */
     public function nullable(): static;




     /**
      * Set column default value
      *
      * @param $value
      * @return mixed
     */
     public function default($value);
}