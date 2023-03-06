<?php
namespace Lexus\Component\Database\Query\Builder\SQL\Commands;

use Lexus\Component\Database\Query\Builder\SQL\Commands\Common\SqlBuilder;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Traits\HasAttributes;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Traits\HasConditions;


class Update extends SqlBuilder
{

    use HasConditions, HasAttributes;


    /**
     * @var array
    */
    protected $data = [];




    /**
     * @param string $column
     * @param $value
     * @return $this
    */
    public function set(string $column, $value): static
    {
         $this->data[] = "$column = $value";

         $this->withAttributes([$column => $value]);

         return $this;
    }





    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
        $sql[]  = sprintf('UPDATE %s', $this->getTable());

        if (! empty($this->data)) {
            $sql[] = sprintf('SET %s', join(", ", $this->data));
        }

        $sql[]  = $this->getConditionSQL();

        return join(' ', array_filter($sql)) . ";";
    }





    /**
     * @return mixed
    */
    public function execute()
    {
        return $this->statement()->execute();
    }

}