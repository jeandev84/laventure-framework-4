<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO;

use Laventure\Component\Database\Connection\Extensions\PDO\Exception\PdoStatementException;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Connection\Query\QueryLoggerInterface;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;
use PDO;
use PDOStatement;

class Statement implements QueryInterface, QueryLoggerInterface
{


    /**
     * @var PDO
    */
    protected $pdo;



    /**
     * @var string
    */
    protected $sql;


    /**
     * @var array
    */
    protected $params = [];



    /**
     * @var PDOStatement
    */
    protected $statement;



    /**
     * @var array
    */
    protected $bindings = [];



    /**
     * @var array
    */
    protected $executed = [];




    /**
     * @param PDO $pdo
    */
    public function __construct(PDO $pdo)
    {
         $this->pdo       = $pdo;
         $this->statement = new PDOStatement();
    }



    /**
     * @inheritDoc
    */
    public function prepare(string $sql, array $params = []): self
    {
         $this->statement = $this->pdo->prepare($sql);
         $this->sql       = $sql;
         $this->params    = $params;

         return $this;
    }





    /**
     * Get params
     *
     * @return array
    */
    public function getParams(): array
    {
         if (! empty($this->bindings)) {
              return $this->bindings;
         }

         return $this->params;
    }



    /**
     * @param string $param
     * @param $value
     * @param int $type
     * @return $this
    */
    public function bindParam(string $param, $value, int $type = 0): self
    {
        if ($type === 0) {

            $name = strtolower(gettype($value));

            $type = [
                'integer' => \PDO::PARAM_INT,
                'boolean' => \PDO::PARAM_BOOL,
                'null'    => \PDO::PARAM_NULL,
            ][$name] ?? \PDO::PARAM_STR;
        }

        $this->statement->bindValue(":{$param}", $value, $type);

        $this->bindings[$param] = [
            'value' => $value,
            'type'  => $type
        ];

        return $this;
    }




    /**
     * @inheritDoc
    */
    public function execute()
    {
        try {

           if ($this->statement->execute($this->params)) {
                $this->logSQL($this->sql, $this->getParams());
                return true;
           }

        } catch (\PDOException $exception) {

              return (function () use ($exception) {
                  throw new PdoStatementException($exception->getMessage());
              })();
        }
    }




    /**
     * @inheritDoc
    */
    public function executeSQL(string $sql): bool
    {
        if ($this->pdo->exec($sql)) {
            $this->logSQL($sql);
            return true;
        }

        return false;
    }




    /**
     * @inheritDoc
    */
    public function lastInsertId(): int
    {
         return $this->pdo->lastInsertId();
    }




    /**
     * @inheritDoc
    */
    public function fetch(): QueryResultInterface
    {
         $this->execute();

         return new QueryResult($this->statement);
    }



    /**
     * @inheritDoc
    */
    public function getQueriesLog(): array
    {
         return $this->executed;
    }




    /**
     * @param string $sql
     * @param array $params
     * @return void
    */
    protected function logSQL(string $sql, array $params = []): void
    {
         $this->executed[] = compact('sql', 'params');
    }
}