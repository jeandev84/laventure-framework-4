<?php
namespace Lexus\Component\Database\Query\Builder\SQL\Commands;

use Lexus\Component\Database\Query\Builder\SQL\Commands\Common\SqlBuilder;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Traits\HasConditions;

class Delete extends SqlBuilder
{

    use HasConditions;


    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
        $sql[] = sprintf('DELETE FROM %s', $this->getTable());
        $sql[] = $this->getConditionSQL();
        return join(' ', array_filter($sql)) . ";";
    }



    public function execute()
    {
         return $this->statement()->execute();
    }
}