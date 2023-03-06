<?php
namespace Lexus\Component\Database\Connection\Configuration;

use ArrayAccess;


class Configuration implements ConfigurationInterface, ArrayAccess
{

    /**
     * @var array
    */
    protected $credentials = [];



    /**
     * @param array $credentials
    */
    public function __construct(array $credentials)
    {
         $this->credentials = $credentials;
    }



    /**
     * @param string $name
     * @return bool
    */
    public function has(string $name): bool
    {
         return isset($this->credentials[$name]);
    }




    /**
     * @param string $name
     * @param $default
     * @return mixed|null
    */
    public function get(string $name, $default = null): mixed
    {
         return $this->credentials[$name] ?? $default;
    }



    /**
     * @param string $name
     * @return void
    */
    public function remove(string $name): void
    {
         unset($this->credentials[$name]);
    }



    /**
     * @return array
    */
    public function getCredentials(): array
    {
        return $this->credentials;
    }




    /**
     * @param mixed $offset
     * @return bool
    */
    public function offsetExists(mixed $offset): bool
    {
         return $this->has($offset);
    }


    /**
     * @param mixed $offset
     * @return mixed
    */
    public function offsetGet(mixed $offset): mixed
    {
         return $this->get($offset);
    }


    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
    */
    public function offsetSet(mixed $offset, mixed $value): void
    {
         $this->credentials[$offset] = $value;
    }


    /**
     * @param mixed $offset
     * @return void
    */
    public function offsetUnset(mixed $offset): void
    {
         $this->remove($offset);
    }




    /**
     * @return string|null
     */
    public function getDatabase(): ?string
    {
        return $this['database'];
    }





    /**
     * @return string|null
    */
    public function getUsername(): ?string
    {
        return $this['username'];
    }




    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this['password'];
    }





    /**
     * @return string|null
    */
    public function getHost(): ?string
    {
        return $this['host'];
    }
}