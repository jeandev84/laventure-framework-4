<?php
namespace Laventure\Component\Database\Query\Builder\SQL\Commands;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Adapter\SelectQuery;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Common\SqlBuilder;
use Laventure\Component\Database\Query\Builder\SQL\Commands\Traits\HasConditions;


class Select extends SqlBuilder
{


    use HasConditions;



    /**
     * @var string[]
    */
    protected $selects = [];



    /**
     * @var int
    */
    protected $offset = 0;




    /**s
     * @var int
    */
    protected $limit = 0;



    /**
     * @var bool
    */
    protected $distinct = false;



    /**
     * @var string
    */
    protected $from;




    /**
     * @var string[]
     */
    protected $orderBy = [];



    /**
     * @var string
    */
    protected $joins = [];



    /**
     * @var string
    */
    protected $groupBy = [];




    /**
     * @var string[]
    */
    protected $having = [];




    /**
     * @var SelectQuery
    */
    protected $query;




    /**
     * @inheritDoc
    */
    public function __construct(ConnectionInterface $connection, string $table)
    {
          parent::__construct($connection, $table);

          $this->query = new SelectQuery();
    }



    /**
     * @param bool $distinct
     * @return $this
    */
    public function distinct(bool $distinct): static
    {
          $this->distinct = $distinct;

          return $this;
    }



    /**
     * @param string $select
     * @return $this
    */
    public function addSelect(string $select): static
    {
        $this->selects[] = $select;

        return $this;
    }




    /**
     * @param string $orderBy
     * @return $this
    */
    public function addOrderBy(string $orderBy): static
    {
         $this->orderBy[] = $orderBy;

         return $this;
    }



    /**
     * @param string $table
     * @param string $alias
     * @return $this
    */
    public function from(string $table, string $alias = ''): static
    {
          $this->from = $alias ? "$table AS $alias" : $table;

          $this->table = $table;

          return $this;
    }



    /**
     * @param string $column
     * @param string $direction
     * @return $this
    */
    public function orderBy(string $column, string $direction = 'asc'): static
    {
          return $this->addOrderBy(sprintf('%s %s', $column, strtoupper($direction)));
    }



    /**
     * @param array $orderBy
     * @return $this
    */
    public function ordersBy(array $orderBy): static
    {
         foreach ($orderBy as $column => $direction) {
              $this->orderBy($column, $direction);
         }

         return $this;
    }




    /**
     * @param string $table
     * @param string $condition
     * @param string|null $type
     * @return Select
    */
    public function join(string $table, string $condition, string $type = null): static
    {
         $type = $type ? strtoupper($type). " JOIN" : "JOIN";

         $this->joins[] = sprintf('%s %s ON %s', $type, $table, $condition);
         
         return $this;
    }




    /**
     * @param string $table
     * @param string $condition
     * @return $this
    */
    public function innerJoin(string $table, string $condition): static
    {
         return $this->join($table, $condition, "INNER");
    }




    /**
     * @param string $table
     * @param string $condition
     * @return $this
    */
    public function leftJoin(string $table, string $condition): static
    {
         return $this->join($table, $condition, "LEFT");
    }




    /**
     * @param string $table
     * @param string $condition
     * @return $this
    */
    public function rightJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "RIGHT");
    }





    /**
     * @param string $table
     * @param string $condition
     * @return $this
    */
    public function fullJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "FULL");
    }




    /**
     * @param string $column
     * @return $this
    */
    public function groupBy(string $column): static
    {
         $this->groupBy[] = $column;

         return $this;
    }




    /**
     * @param string $condition
     * @return $this
    */
    public function having(string $condition): self
    {
        $this->having[] = $condition;

        return $this;
    }




    /**
     * @param int $offset
     * @return $this
    */
    public function setFirstResult(int $offset): static
    {
         $this->offset = $offset;

         return $this;
    }




    /**
     * @param int $limit
     * @return $this
    */
    public function setMaxResults(int $limit): static
    {
         $this->limit = $limit;

         return $this;
    }



    /**
     * Fetch data
     *
     * @return QueryResultInterface
    */
    public function fetch(): QueryResultInterface
    {
         return $this->statement()->fetch();
    }




    /**
     * @param SelectQuery $query
     * @return $this
    */
    public function setQuery(SelectQuery $query): static
    {
         $this->query = $query;

         return $this;
    }





    /**
     * @return SelectQuery
    */
    public function getQuery(): SelectQuery
    {
        return $this->query->statement($this->statement());
    }






    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
         $selects = join(', ', $this->selects);
         $sql[] = sprintf('SELECT%s %s FROM %s', $this->distinct ? ' DISTINCT' : '', $selects, $this->getTable());

         if (! empty($this->joins)) {
             $sql[] = join($this->joins);
         }

         $sql[] = $this->getConditionSQL();

         if (! empty($this->groupBy)) {
             $sql[] = sprintf('GROUP BY %s', join($this->groupBy));
         }

         if (! empty($this->having)) {
             $sql[] = sprintf('HAVING %s', join($this->having));
         }

         if (! empty($this->orderBy)) {
             $sql[] = sprintf('ORDER BY %s', join(',', $this->orderBy));
         }


         if ($this->limit) {
             $sql[] = "LIMIT {$this->limit}". ($this->offset ? " OFFSET {$this->offset}" : "");
         }

         return join(' ', array_filter($sql)) . ";";
    }




    /**
     * @return string
    */
    public function getTable(): string
    {
        if ($this->from) {
            return $this->from;
        }

        return parent::getTable();
    }
}