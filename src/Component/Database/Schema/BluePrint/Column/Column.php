<?php
namespace Laventure\Component\Database\Schema\BluePrint\Column;

use Laventure\Component\Database\Schema\BluePrint\Column\Contract\ColumnInterface;


class Column implements ColumnInterface
{

    /**
     * @var string
    */
    protected $name;


    /**
     * @var string
    */
    protected $type;




    /**
     * @var array
    */
    protected $options = [
        'default' => 'NOT NULL'
    ];




    /**
     * @param string $name
     * @param string $type
     * @param array $options
    */
    public function __construct(string $name, string $type, array $options = [])
    {
         $this->name    = $name;
         $this->type    = $type;
         $this->options = array_merge($this->options, $options);
    }




    /**
     * @param string $name
     * @return $this
    */
    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }




    /**
     * @param string $name
     * @return $this
    */
    public function type(string $name): static
    {
         $this->type = $name;

         return $this;
    }





    /**
     * @param string $name
     * @param $value
     * @return $this
    */
    public function option(string $name, $value): static
    {
        return $this->options([$name => $value]);
    }



    /**
     * @param array $options
     * @return $this
    */
    public function options(array $options): static
    {
         foreach ($options as $name => $value) {
              $this->options[$name] = $value;
         }

         return $this;
    }



    /**
     * @inheritDoc
    */
    public function getName(): string
    {
         return $this->name;
    }




    /**
     * @inheritDoc
    */
    public function getType(): string
    {
        return $this->type;
    }


    /**
     * @inheritDoc
    */
    public function unique(): static
    {
         return $this->options(['unique' => 'UNIQUE']);
    }



    /**
     * @return $this
    */
    public function primaryKey(): static
    {
        return $this->options(['primaryKey' => 'PRIMARY KEY']);
    }




    /**
     * @inheritDoc
    */
    public function nullable(): static
    {
         return $this->default('NULL');
    }





    /**
     * @inheritDoc
    */
    public function default($value): static
    {
        return $this->options(['default' => "DEFAULT '{$value}'"]);
    }





    /**
     * @inheritDoc
    */
    public function getOptions(): array
    {
        return $this->options;
    }





    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        return sprintf('%s %s %s', $this->name, $this->type, join(' ', array_values($this->options)));
    }
}