<?php
namespace Lexus\Component\Database\Query\Builder\SQL\Commands\Adapter;


use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\Query\QueryInterface;


/**
 * Select Query adapter
 *
 * @class SelectQuery
 */
class SelectQuery
{


    /**
     * @var ConnectionInterface
     */
    protected $connection;



    /**
     * @var QueryInterface
     */
    protected $statement;



    /**
     * @var string
    */
    protected $classname;



    /**
     * @param string|null $classname
    */
    public function __construct(string $classname = null)
    {
        $this->statement = new QueryNullStatement();
        $this->classname = $classname ?: new \stdClass();
    }




    /**
     * @param QueryInterface $statement
     * @return $this
     */
    public function statement(QueryInterface $statement): static
    {
        $statement->map($this->classname);
        $this->statement = $statement;

        return $this;
    }





    /**
     * @return array
    */
    public function getResult(): array
    {
        return $this->statement->fetch()->all();
    }




    /**
     * @return object|bool
    */
    public function getOneOrNullResult(): object|bool
    {
        return $this->statement->fetch()->one();
    }




    /**
     * @return array
    */
    public function getArrayResult(): array
    {
        return $this->statement->fetch()->assoc();
    }





    /**
     * @return array
    */
    public function getArrayColumns(): array
    {
        return $this->statement->fetch()->columns();
    }
}