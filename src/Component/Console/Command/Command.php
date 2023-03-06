<?php
namespace Laventure\Component\Console\Command;

use Laventure\Component\Console\Command\Contract\CommandInterface;
use Laventure\Component\Console\Input\Contract\InputInterface;
use Laventure\Component\Console\Input\InputDefinition;
use Laventure\Component\Console\Output\Contract\OutputInterface;


class Command implements CommandInterface
{

    const SUCCESS  = 0;
    const FAILURE  = 1;



    /**
     * Default name of command
     *
     * @var string
    */
    protected $defaultName;




    /**
     * Name of command
     *
     * @var string
    */
    protected $name;




    /**
     * Command description
     *
     * @var array|string
    */
    protected $description;





    /**
     * Help command name
     *
     * @var mixed
    */
    protected $help;





    /**
     * Input definition
     *
     * @var InputDefinition
    */
    protected $inputs;




    /**
     * @param string|null $name
    */
    public function __construct(string $name = null)
    {
        $this->inputs = new InputDefinition();

        if ($name) {
            $this->name($name);
        }

        $this->configure();
    }




    /**
     * Set command default name
     *
     * @param string $name
     * @return $this
    */
    public function defaultName(string $name): static
    {
        $this->defaultName = $name;

        return $this;
    }




    /**
     * @return string|null
    */
    public function getDefaultName(): ?string
    {
        return $this->defaultName;
    }




    /**
     * @param string $name
     * @return $this
    */
    public function name(string $name): static
    {
         if (! self::validateName($name)) {
            return $this->defaultName($name);
         }

         $this->name = $name;

         return $this;
    }




    /**
     * @inheritDoc
    */
    public function getName(): string
    {

    }





    /**
     * @inheritDoc
     * @return int
    */
    public function execute(InputInterface $input, OutputInterface $output): int
    {

    }



    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
    */
    public function run(InputInterface $input, OutputInterface $output)
    {

    }




    /**
     * @param $name
     * @return bool
    */
    public static function validateName($name): bool
    {
        return ! is_null($name) && stripos($name, ':') !== false;
    }




    /**
     * Command configuration
     *
     * @return void
    */
    protected function configure(): void {}
}