<?php
namespace Lexus\Component\Dotenv;

class Dotenv
{

    /**
     * @var string
    */
    private $root;



    /**
     * @var Env[]
    */
    private $environments = [];




    /**
     * @param string $root
    */
    public function __construct(string $root)
    {
         $this->root = $root;
    }



    /**
     * @param string $filename
     * @return array
    */
    public function load(string $filename = '.env'): array
    {
        foreach ($this->loadEnvironmentsFromFile($filename) as $environment) {
             $this->environments[] = new Env($environment);
        }

        return $this->environments;
    }




    /**
     * @param string $filename
     * @return array
    */
    protected function loadEnvironmentsFromFile(string $filename): array
    {
         if(! $filename = realpath($this->root . DIRECTORY_SEPARATOR . $filename)) {
              return [];
         }

         $params = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

         return array_filter($params, function ($value) {
             return stripos($value, '#') === false;
         });
    }
}