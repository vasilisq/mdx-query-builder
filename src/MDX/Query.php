<?php

namespace Vasilisq\MdxQueryBuilder\MDX;

use Vasilisq\MdxQueryBuilder\CellSet;
use Vasilisq\MdxQueryBuilder\MDX\Expressions\Raw;
use Vasilisq\MdxQueryBuilder\MDX\Exceptions\MalformedMdxQuery;
use Vasilisq\MdxQueryBuilder\OLAP\ConnectionInterface;

class Query implements QueryInterface
{
    public const AS_PART = ' as ';

    /** @var array */
    protected $columns = [];

    /** @var array */
    protected $rows = [];

    /** @var array */
    protected $columnAliases = [];

    /** @var array */
    protected $whereClauses = [];

    /** @var array */
    protected $withMembers;

    /** @var array */
    protected $withSets;

    /** @var string */
    protected $cube;

    /** @var ConnectionInterface */
    protected $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function withMember(string $alias, Expression $expression, ?string $formatString = null): QueryInterface
    {
        $this->withMembers[$alias] = new Raw($expression . (is_null($formatString) ? '' : ", FORMAT_STRING = '{$formatString}'"));

        return $this;
    }

    public function withSet(string $alias, Expression $expression): QueryInterface
    {
        $this->withSets[$alias] = $expression;

        return $this;
    }

    public function select($columns): QueryInterface
    {
        $columns = array_wrap($columns);
        $aliases = [];

        foreach ($columns as $columnIndex => $column) {
            if ($asPosition = stripos($column, static::AS_PART)) {
                $columnName = trim(substr($column, 0, $asPosition));
                $columnAlias = trim(substr($column, $asPosition + strlen(static::AS_PART)));

                $columns[$columnIndex] = $columnName;
                $aliases[$columnIndex] = $columnAlias;
            }
        }

        $this->columns = array_merge($this->columns, array_wrap($columns));
        $this->columnAliases = array_merge($this->columnAliases, array_wrap($aliases));

        return $this;
    }

    public function by($rows): QueryInterface
    {
        $this->rows = array_merge($this->rows, array_wrap($rows));

        return $this;
    }

    public function from($cube): QueryInterface
    {
        $this->cube = $cube;

        return $this;
    }

    public function where($clause): QueryInterface
    {
        $this->whereClauses = array_merge($this->whereClauses, array_wrap($clause));

        return $this;
    }

    public function execute(): CellSet
    {
        return $this->connection->executeQuery($this);
    }

    public function toMDX(): string
    {
        if (empty($this->cube)) {
            throw new MalformedMdxQuery('No cube selected!');
        }

        $mdx = $this->withToMdx() . "SELECT {{$this->columnsToMdx()}} ON COLUMNS";

        if (! empty($this->rows)) {
            $mdx .= ',';

            $mdx .= "{{$this->rowsToMdx()}} ON ROWS";
        }

        $mdx .= " FROM [{$this->cube}]";

        if (! empty($this->whereClauses)) {
            $mdx .= ' WHERE '. implode(' * ', $this->whereClauses); // todo: or?
        }

        return $this->sanitizeQuery($mdx);
    }

    public function getColumnAliases(): array
    {
        return $this->columnAliases;
    }

    protected function sanitizeQuery(string $mdx): string
    {
        return trim(preg_replace('/\s+/', ' ', $mdx));
    }

    protected function withToMdx(): string
    {
        $with = '';

        if (empty($this->withMembers) && empty($this->withSets)) {
            return $with;
        }

        foreach ($this->withMembers as $alias => $expression) {
            $with .= "MEMBER {$alias} AS {$expression} ";
        }

        foreach ($this->withSets as $alias => $expression) {
            $with .= "SET {$alias} AS {$expression} ";
        }

        return "WITH {$with}";
    }

    protected function columnsToMdx(): string
    {
        if (empty($this->columns)) {
            throw new MalformedMdxQuery('No columns passed!');
        }

        return implode(', ', $this->columns);
    }

    protected function rowsToMdx(): string
    {
        return implode(', ', $this->rows);
    }
}
