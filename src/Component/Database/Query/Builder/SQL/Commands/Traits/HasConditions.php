<?php
namespace Lexus\Component\Database\Query\Builder\SQL\Commands\Traits;

trait HasConditions
{
    /**
     * @var array
    */
    protected $wheres = [];


    /**
     * @param string $condition
     * @return $this
    */
    public function where(string $condition): static
    {
        return $this->andWhere($condition);
    }







    /**
     * @param string $condition
     * @return $this
     */
    public function andWhere(string $condition): static
    {
        $this->wheres['AND'][] = $condition;

        return $this;
    }



    /**
     * @param string $condition
     * @return $this
    */
    public function orWhere(string $condition): static
    {
        $this->wheres['OR'][] = $condition;

        return $this;
    }




    /**
     * @param string $condition
     * @return $this
    */
    public function notWhere(string $condition): static
    {
        return $this->andWhere("NOT $condition");
    }



    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereLike($column, $value): static
    {
        return $this->andWhere("$column LIKE $value");
    }





    /**
     * @param string $column
     * @param string $start
     * @param string $end
     * @return $this
    */
    public function whereBetween(string $column, string $start, string $end): static
    {
        return $this->andWhere("$column BETWEEN $start AND $end");
    }




    /**
     * @param string $column
     * @param string $first
     * @param string $end
     * @return $this
     */
    public function whereNotBetween(string $column, string $first, string $end): static
    {
        return $this->whereBetween("$column NOT", $first, $end);
    }



    /**
     * @param string $column
     * @param array $data
     * @return $this
     */
    public function whereIn(string $column, array $data): static
    {
        $values = "'". implode("', '", $data) . "'";

        return $this->andWhere(sprintf("%s IN (%s)", $column, $values));
    }



    /**
     * @param string $column
     * @param array $data
     * @return $this
    */
    public function whereNotIn(string $column, array $data): static
    {
        return $this->whereIn("$column NOT", $data);
    }


    /**
     * @param array $conditions
     * @return $this
    */
    public function addConditions(array $conditions): static
    {
         foreach ($conditions as $condition) {
              $this->andWhere($condition);
         }

         return $this;
    }



    /**
     * @return string
    */
    protected function getConditionSQL(): string
    {
        if (empty($this->wheres)) {
             return "";
        }

        $wheres = [];
        $key    = key($this->wheres);

        foreach ($this->wheres as $operator => $conditions) {

            if ($key !== $operator) {
                $wheres[] = $operator;;
            }

            $wheres[] =  implode(" ". $operator . " ", $conditions);
        }

        return sprintf('WHERE %s', join(' ', $wheres));
    }
}