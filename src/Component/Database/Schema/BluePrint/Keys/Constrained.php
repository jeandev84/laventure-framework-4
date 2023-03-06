<?php
namespace Laventure\Component\Database\Schema\BluePrint\Keys;

class Constrained
{


    /**
     * @var array
    */
    protected $constrained = [];





    /**
     * @param string|null $value
     * @return $this
    */
    public function onDelete(string $value = null): static
    {
        $constrained = sprintf('ON DELETE %s', $value ? ucfirst($value) : 'SET NULL');

        $this->constrained['DELETE'] = $constrained;

        return $this;
    }





    /**
     * @param string|null $value
     * @return $this
    */
    public function onUpdate(string $value = null): static
    {
        $constrained = sprintf('ON UPDATE %s', $value ? ucfirst($value) : 'SET NULL');

        $this->constrained['UPDATE'] = $constrained;

        return $this;
    }




    /**
     * @return string
    */
    public function __toString(): string
    {
         return join(' ', array_values($this->constrained));
    }
}