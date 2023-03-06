<?php
namespace Laventure\Component\Database\Manager;


use Laventure\Component\Database\Connection\ConnectionFactory;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Exception\ConnectionFactoryException;

/**
 * @class DatabaseManager
 *
 * @package Laventure\Component\Database\Manager
 *
 * @author Yao Kouassi Jean-Claude <jeanyao@ymail.com php>
*/
class DatabaseManager implements DatabaseManagerInterface
{

      /**
       * @var string
      */
      protected $name;




      /**
       * @var ConnectionFactory
      */
      protected $factory;



      /**
       * @var ConnectionInterface[]
      */
      protected $connections = [];




      /**
       * @var array
      */
      protected $configurations = [];




      /**
       * @param array $credentials
      */
      public function __construct(array $credentials = [])
      {
           $this->factory = new ConnectionFactory();
           $this->setConfigurations($credentials);
      }




      /**
       * Set name of connection
       *
       * @param string $name
       * @return $this
      */
      public function name(string $name): self
      {
            $this->name = $name;

            return $this;
      }




      /**
       * @return string
      */
      public function getName(): string
      {
           return $this->name;
      }



      /**
       * @param $name
       * @return bool
      */
      public function hasConnection($name): bool
      {
           return isset($this->connections[$name]);
      }



     /**
      * @param ConnectionInterface $connection
      * @return $this
     */
     public function setConnection(ConnectionInterface $connection): self
     {
          $this->connections[$connection->getName()] = $connection;

          return $this;
     }




    /**
     * @param ConnectionInterface[] $connections
     * @return $this
    */
    public function setConnections(array $connections): self
    {
        foreach ($connections as $connection) {
             $this->setConnection($connection);
        }

        return $this;
    }






     /**
      * @param string $name
      * @param array $credentials
      * @return $this
     */
     public function setConfiguration(string $name, array $credentials): self
     {
          $this->configurations[$name] = $credentials;

          return $this;
     }





     /**
      * @param array $parameters
      * @return $this
     */
     public function setConfigurations(array $parameters): self
     {
          foreach ($parameters as $name => $credentials) {
                $this->setConfiguration($name, $credentials);
          }

          return $this;
     }



     /**
      * @param string $name
      * @return array
     */
     public function configuration(string $name): array
     {
          return $this->configurations[$name] ?? [];
     }



     /**
      * @return array
     */
     public function getConfigurations(): array
     {
          return $this->configurations;
     }




    /**
     * @return ConnectionInterface[]
    */
    public function getConnections(): array
    {
        return $this->connections;
    }



    /**
     * @inheritDoc
    */
    public function connect($name, array $credentials)
    {
        $this->name($name);
        $this->setConfiguration($name, $credentials);
    }





    /**
     * @inheritDoc
     */
    public function connection($name = null): ?ConnectionInterface
    {
         $name   = $this->getParsedName($name);

         // dd($this->getConfiguration($name));

         if (! $config = $this->configuration($name)) {
              return null;
         }

         if ($this->hasConnection($name)) {
              $this->connections[$name]->connect($config);
              return $this->connections[$name];
         }

         return $this->connections[$name] = $this->factory->make($name, $config);
    }




    /**
     * @inheritDoc
    */
    public function disconnect($name = null)
    {
         $name  = $this->getParsedName($name);

         if ($this->hasConnection($name)) {
            $connection = $this->connections[$name];
            if ($connection->connected()) {
                $connection->disconnect();
                unset($this->configurations[$name]);
            }
        }
    }




    /**
     * @inheritDoc
    */
    public function reconnect($name = null)
    {
        $name  = $this->getParsedName($name);

        if ($this->hasConnection($name)) {
              $this->connections[$name]->reconnect();
        }
    }




    /**
     * @inheritDoc
    */
    public function purge($name = null)
    {
        $name  = $this->getParsedName($name);

        $this->disconnect($name);

        unset($this->connections[$name]);
    }




    /**
     * @param $name
     * @return string
    */
    private function getParsedName($name): string
    {
         return $name ?: $this->getName();
    }
}