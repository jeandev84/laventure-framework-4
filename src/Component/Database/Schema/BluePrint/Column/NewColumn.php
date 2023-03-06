<?php
namespace Lexus\Component\Database\Schema\BluePrint\Column;

class NewColumn extends Column
{


    public function __construct(string $name, string $type, array $options = [])
    {
        parent::__construct($name, $type, $options);
    }


    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        $column[] = "ADD";
        $column[] = parent::__toString();
        return join(' ', $column);
    }
}