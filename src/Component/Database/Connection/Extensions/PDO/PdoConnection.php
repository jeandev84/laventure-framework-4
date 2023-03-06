<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO;


use Exception;
use Laventure\Component\Database\Connection\Configuration\Configuration;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Extensions\PDO\Contract\PdoConnectionInterface;
use Laventure\Component\Database\Connection\Extensions\PDO\Exception\PdoConnectionException;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Connection\Query\QueryLoggerInterface;
use PDO;
use PDOException;


class PdoConnection implements PdoConnectionInterface
{

    /**
     * @var array
    */
    protected $options = [
        PDO::ATTR_PERSISTENT          => true,
        PDO::ATTR_EMULATE_PREPARES    => 0,
        PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION
    ];




    /**
     * @var bool
    */
    protected $reconnected = false;




    /**
     * @var PDO
    */
    protected $pdo;




    /**
     * @var Configuration
    */
    protected $config;




    /**
     * @var Statement[]
    */
    protected $statements = [];





    /**
     * @param array $config
     * @throws PdoConnectionException
    */
    public function __construct(array $config = [])
    {
         if ($config) {
             $this->connect($config);
         }
    }




    /**
     * @throws PdoConnectionException
     * @throws Exception
    */
    public function connect($config)
    {
        if (! $this->connected()) {
            $config       = $this->prepareConfiguration($config);
            $this->config = new Configuration($config);
            $this->pdo    = $this->make($config);
        }
    }




    /**
     * @return bool
    */
    public function connected(): bool
    {
        return $this->pdo instanceof PDO;
    }




    /**
     * @return bool
    */
    public function reconnected(): bool
    {
        return $this->reconnected;
    }




    /**
     * @return void
     * @throws Exception
    */
    public function reconnect(): void
    {
         if ($this->connected()) {

             $this->config['dsn'] = sprintf('%s;dbname=%s', trim($this->config['dsn'], ';'), $this->getDatabase());

             $this->pdo = $this->make($this->config->getCredentials());

             $this->reconnected = true;
         }
    }






    /**
     * @return void
    */
    public function disconnect(): void
    {
        $this->pdo = null;
    }




    /**
     * @param string $sql
     * @param array $params
     * @return QueryInterface
    */
    public function statement(string $sql, array $params = []): QueryInterface
    {
        $statement = new Statement($this->getPdo());
        $statement->prepare($sql, $params);
        $this->statements[] = $statement;
        return $statement;
    }




    /**
     * @return PDO
    */
    public function getConnection(): PDO
    {
        return $this->getPdo();
    }




    /**
     * @return void
    */
    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }




    /**
     * @return void
    */
    public function commit(): void
    {
        $this->pdo->commit();
    }




    /**
     * @return void
    */
    public function rollback(): void
    {
        $this->pdo->rollBack();
    }




    /**
     * @param $name
     * @return int
    */
    public function lastInsertId($name = null): int
    {
        return $this->pdo->lastInsertId($name);
    }




    /**
     * @param $sql
     * @return bool
    */
    public function exec($sql): bool
    {
        $statement = new Statement($this->getPdo());
        $executed = $statement->executeSQL($sql);
        $this->statements[] = $statement;
        return $executed;
    }



    /**
     * @inheritDoc
    */
    public function getPdo(): PDO
    {
        if (! $this->connected()) {
            throw new PDOException("No connection established.");
        }

        return $this->pdo;
    }




    /**
     * @param string $name
     * @return mixed
    */
    public function config(string $name): mixed
    {
        return $this->config[$name];
    }




    /**
     * @return string
    */
    public function getDatabase(): string
    {
         return $this->config->getDatabase();
    }




    /**
     * Make PDO connection
     *
     * @param array $config
     * @return PDO
     * @throws Exception
    */
    public function make(array $config): PDO
    {
        try {

            $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

            $config['options'][] = sprintf("SET NAMES '%s'", $config['charset'] ?? 'utf8');

            foreach ($config['options'] as $option) {
                $pdo->exec($option);
            }

            foreach ($this->options as $key => $value) {
                $pdo->setAttribute($key, $value);
            }

            return $pdo;

        } catch (PDOException $exception) {

            throw new PdoConnectionException($exception->getMessage());
        }
    }




    /**
     * @return array
    */
    public function getQueriesLog(): array
    {
         $executedQueries = [];

         foreach ($this->statements as $statement) {
              if ($statement instanceof QueryLoggerInterface) {
                  $executedQueries[] = $statement->getQueriesLog();
              }
         }

         return $executedQueries;
    }





    /**
     * @param string $name
     * @return bool
    */
    private function driverExists(string $name): bool
    {
        return in_array($name, PDO::getAvailableDrivers());
    }






    /**
     * @param array $config
     * @return array
     * @throws PdoConnectionException
    */
    private function prepareConfiguration(array $config): array
    {
         if (empty($config['driver'])) {
            throw new PdoConnectionException("No driver provided from configuration.");
         }

         if (! $this->driverExists($config['driver'])) {
             throw new PdoConnectionException("Unavailable driver '{$config['driver']}'.");
         }

         if (empty($config['dsn'])) {
            $config['dsn'] = sprintf('%s:host=%s;port=%s', $config['driver'], $config['host'], $config['port']);
         }

         return $config;
    }
}