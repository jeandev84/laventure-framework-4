<?php
namespace Lexus\Component\Database\Query\Builder\SQL\Commands\Traits;

trait HasAttributes
{
    /**
     * @var array
    */
    protected $attributes = [];



    /**
     * @param array $attributes
     * @return $this
    */
    public function withAttributes(array $attributes): static
    {
         foreach ($attributes as $column => $value) {
             $this->attributes[$column] = $value;
         }

         return $this;
    }




    /**
     * @return array
    */
    public function getAttributes(): array
    {
         return $this->attributes;
    }
}