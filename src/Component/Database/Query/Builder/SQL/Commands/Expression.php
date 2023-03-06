<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Commands;

class Expression
{

     /**
      * @var array
     */
     protected $sql = [];



     /**
      * @var array
     */
     protected $orX = [];



     /**
      * @var array
     */
     protected $andX = [];



     /**
      * @param string $column
      * @return $this
     */
     public function avg(string $column): static
     {
         $this->sql[] = "AVG($column)";

         return $this;
     }


     /**
      * @param string $column
      * @return $this
     */
     public function min(string $column): static
     {
         $this->sql[] = "MIN($column)";

         return $this;
     }


     /**
      * @param string $column
      * @param string|null $alias
      * @return $this
     */
     public function max(string $column, string $alias = null): static
     {
         $expression = "MAX($column)";

         $this->sql[] = $alias ? "$expression AS $alias" : $expression;

         return $this;
     }


     /**
      * @param string $column
      * @return $this
     */
     public function count(string $column = "*"): static
     {
         $this->sql[] = "COUNT($column)";

         return $this;
     }


     /**
      * @param string $column
      * @return $this
     */
     public function sum(string $column): static
     {
         $this->sql[] = "SUM($column)";

         return $this;
     }




     /**
      * @return $this
     */
     public function like(): static
     {
         return $this;
     }




     /**
      * @return $this
     */
     public function in(): static
     {
         return $this;
     }


     /**
      * @return $this
     */
     public function orX(): static
     {
         return $this;
     }



     /**
      * @return $this
     */
     public function andX(): static
     {
         return $this;
     }



     /**
      * @return string
     */
     public function __toString(): string
     {
         return join(', ', $this->sql);
     }
}