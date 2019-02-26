<?php
declare(strict_types=1);
namespace Vasilisq\MdxQueryBuilder\MDX;

use Vasilisq\MdxQueryBuilder\CellSet;
use Vasilisq\MdxQueryBuilder\MDX\Expressions\Raw;
use Vasilisq\MdxQueryBuilder\OLAP\ConnectionInterface;
use Vasilisq\MdxQueryBuilder\MDX\Exceptions\MalformedMdxQuery;

/**
 * QueryInterface implementation
 *
 * @package Vasilisq\MdxQueryBuilder\MDX
 */
class Query implements QueryInterface
{
    /** @var array */
    protected $columns = [];

    /** @var array */
    protected $rows = [];

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

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function withMember(string $alias, Expression $expression, ?string $formatString = null): QueryInterface
    {
        $this->withMembers[$alias] = new Raw(
            $expression . (is_null($formatString) ? '' : ", FORMAT_STRING = '{$formatString}'")
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withSet(string $alias, Expression $expression): QueryInterface
    {
        $this->withSets[$alias] = $expression;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function select($columns): QueryInterface
    {
        $this->columns = array_merge($this->columns, array_wrap($columns));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function by($rows): QueryInterface
    {
        $this->rows = array_merge($this->rows, array_wrap($rows));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function from(string $cube): QueryInterface
    {
        $this->cube = $cube;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function where(Expression $clause): QueryInterface
    {
        $this->whereClauses = array_merge($this->whereClauses, array_wrap($clause));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): CellSet
    {
        return $this->connection->executeQuery($this);
    }

    /**
     * @param string $mdx
     * @return string
     */
    protected function sanitizeQuery(string $mdx): string
    {
        return trim(preg_replace('/\s+/', ' ', $mdx));
    }

    /**
     * {@inheritdoc}
     */
    public function toMDX(): string
    {
        $mdx = $this->buildWith() .
            $this->buildSelect() .
            $this->buildRows() .
            $this->buildFrom() .
            $this->buildWhere();

        return $this->sanitizeQuery($mdx);
    }

    /**
     * @return string
     */
    protected function buildWith(): string
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

    /**
     * @return string
     */
    protected function buildSelect(): string
    {
        if (empty($this->columns)) {
            throw new MalformedMdxQuery('No columns passed!');
        }

        $columns = implode(', ', $this->columns);

        return "SELECT {{$columns}} ON COLUMNS";
    }

    /**
     * @return string
     */
    protected function buildRows(): string
    {
        if (empty($this->rows)) {
            return '';
        }

        $rows = implode(', ', $this->rows);

        return ", {{$rows}} ON ROWS";
    }

    /**
     * @return string
     */
    protected function buildFrom(): string
    {
        if (empty($this->cube)) {
            throw new MalformedMdxQuery('No cube selected!');
        }

        return " FROM [{$this->cube}]";
    }

    /**
     * @return string
     */
    protected function buildWhere(): string
    {
        if (empty($this->whereClauses)) {
            return '';
        }

        $where = implode(' * ', $this->whereClauses);

        return " WHERE {$where}";
    }
}
