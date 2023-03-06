<?php
namespace Lexus\Component\Database\Query\Builder\SQL\Commands\Common;

use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\Query\QueryInterface;
use Lexus\Component\Database\Query\Builder\SQL\Commands\Expression;


abstract class SqlBuilder
{

     /**
      * @var ConnectionInterface
     */
     protected $connection;



     /**
      * @var string
     */
     protected $table;




     /**
      * @var array
     */
     protected $parameters = [];




     /**
      * @param ConnectionInterface $connection
      * @param string $table
     */
     public function __construct(ConnectionInterface $connection, string $table)
     {
          $this->connection = $connection;
          $this->table      = $table;
     }



     /**
      * @return string
     */
     public function getTable(): string
     {
          return $this->table;
     }




    /**
     * @param string $name
     * @param $value
     * @return $this
    */
    public function setParameter(string $name, $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }





    /**
     * @param array $parameters
     * @return $this
    */
    public function setParameters(array $parameters): self
    {
        foreach ($parameters as $name => $value) {
              $this->setParameter($name, $value);
        }

        return $this;
    }




    /**
     * @return array
    */
    public function getParameters(): array
    {
        return $this->parameters;
    }




    /**
     * @return QueryInterface
    */
    public function statement(): QueryInterface
    {
          return $this->connection->statement($this->getSQL(), $this->getParameters());
    }








    /**
     * @return Expression
    */
    public function expr(): Expression
    {
         return new Expression();
    }




    /**
      * @return string
    */
    abstract public function getSQL(): string;
}