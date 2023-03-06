<?php
namespace Laventure\Component\Database\Schema\BluePrint\Column;

class RenameColumn extends Column
{

    /**
     * @var string
    */
    protected $to;


    /**
     * @inheritDoc
    */
    public function __construct(string $name, string $to)
    {
         parent::__construct($name, null);
         $this->to($to);
    }




    /**
     * @param string $name
     * @return $this
    */
    public function to(string $name): static
    {
         $this->to = $name;

         return $this;
    }





    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        $column[] = "RENAME COLUMN";
        $column[] = parent::__toString();
        $column[] = "TO {$this->to}";
        return join(' ', $column);
    }
}