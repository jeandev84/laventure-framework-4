<?php
namespace Lexus\Component\Database\Query\Builder\SQL\Commands;

use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Common\SqlBuilder;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Traits\HasAttributes;

class Insert extends SqlBuilder
{

    use HasAttributes;


    /**
     * @var array
    */
    protected $columns = [];



    /**
     * @var array
    */
    protected $values = [];




    /**
     * @param ConnectionInterface $connection
     * @param string $table
    */
    public function __construct(ConnectionInterface $connection, string $table)
    {
          parent::__construct($connection, $table);
    }



    /**
     * @param array $attributes
     * @return $this
    */
    public function add(array $attributes): static
    {
         $this->columns      = array_keys($attributes);
         $this->values[]     = '('. join(', ', array_values($attributes)) . ')';

         return $this;
    }



    /**
     * @return bool
    */
    public function isMultiple(): bool
    {
         return isset($this->attributes[0]);
    }




    /**
     * @param array $attributes
     * @return $this
    */
    public function addMultiple(array $attributes): static
    {
        foreach ($attributes as $attribute) {
            $this->add($attribute);
        }

        return $this;
    }





    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
        $sql     = "INSERT INTO {$this->getTable()}";
        $columns = join(', ', $this->columns);
        $values  = join(', ', $this->values);

        return sprintf("%s (%s) VALUES %s;", $sql, $columns, $values);
    }




    /**
     * @return int
    */
    public function execute(): int
    {
         $this->statement()->execute();

         $lastId = $this->statement()->lastInsertId();

         if ($this->isMultiple()) {
              return ($lastId + 1);
         }

         return $lastId;
    }
}