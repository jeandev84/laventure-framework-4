<?php
namespace Lexus\Component\Database\Connection\Extensions\PDO\Drivers;

use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\ConnectionType;
use Lexus\Component\Database\Connection\Extensions\PDO\PdoConnection;
use Lexus\Component\Database\Connection\Traits\HasDatabase;

class MysqlConnection extends PdoConnection implements ConnectionInterface
{

    use HasDatabase;


    /**
     * @return string
    */
    public function getName(): string
    {
        return ConnectionType::pdo_mysql;
    }





    /**
     * @inheritDoc
    */
    public function connect($config)
    {
        $config['dsn'] = sprintf('mysql:host=%s;port=%s', $config['host'], $config['port']);

        parent::connect($config);
    }






    /**
     * @inheritDoc
    */
    public function createDatabase(): bool
    {
        $database = $this->getDatabase();

        $this->exec("CREATE DATABASE IF NOT EXISTS {$database};");

        return in_array($database, $this->showDatabases());
    }




    /**
     * @inheritDoc
    */
    public function dropDatabase(): bool
    {
        $database = $this->getDatabase();

        $this->exec("DROP DATABASE IF EXISTS {$database};");

        return ! in_array($database, $this->showDatabases());
    }



    /**
     * @inheritDoc
    */
    public function showDatabases(): array
    {
        return $this->statement('SHOW DATABASES;')
                    ->fetch()
                    ->columns();
    }
    


    /**
     * @inheritDoc
    */
    public function showDatabaseTables(): array
    {
        return $this->statement("SHOW FULL TABLES FROM {$this->getDatabase()};")
                    ->fetch()
                    ->columns();
    }
}