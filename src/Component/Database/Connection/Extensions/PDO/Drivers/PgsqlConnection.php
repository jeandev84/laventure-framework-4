<?php
namespace Lexus\Component\Database\Connection\Extensions\PDO\Drivers;


use Lexus\Component\Database\Connection\ConnectionInterface;
use Lexus\Component\Database\Connection\ConnectionType;
use Lexus\Component\Database\Connection\Extensions\PDO\PdoConnection;
use Lexus\Component\Database\Connection\Traits\HasDatabase;

class PgsqlConnection extends PdoConnection implements ConnectionInterface
{

    use HasDatabase;


    /**
     * @inheritDoc
    */
    public function getName(): string
    {
        return ConnectionType::pdo_pgsql;
    }




    /**
     * @inheritDoc
    */
    public function connect($config)
    {
        $config['dsn'] = sprintf('pgsql:host=%s;port=%s', $config['host'], $config['port']);

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
        return $this->statement('SHOW DATABASES')
            ->fetch()
            ->columns();
    }
    
    



    /**
     * @inheritDoc
    */
    public function showDatabaseTables(): array
    {
         return array_filter($this->showInformationSchema(), function ($information) {
               return ! empty($information->tablename);
         });
    }




    /**
     * @return array
    */
    private function showInformationSchema(): array
    {
         return $this->statement("
                SELECT * FROM pg_catalog.pg_tables 
                WHERE schemaname != 'pg_catalog' 
                AND schemaname != 'information_schema';
                "
         )->fetch()->all();
    }
}