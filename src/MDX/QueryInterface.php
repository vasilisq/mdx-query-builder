<?php

namespace Vasilisq\MdxQueryBuilder\MDX;

use Vasilisq\MdxQueryBuilder\CellSet;

/**
 * MDX Query interface
 *
 * @package Vasilisq\MdxQueryBuilder\MDX
 */
interface QueryInterface
{
    /**
     * Adds member to WITH clause
     *
     * @param string $alias
     * @param Expression $expression
     * @param null|string $formatString
     * @return QueryInterface
     */
    public function withMember(string $alias, Expression $expression, ?string $formatString = null): self;

    /**
     * Adds set to WITH clause
     *
     * @param string $alias
     * @param Expression $expression
     * @return QueryInterface
     */
    public function withSet(string $alias, Expression $expression): self;

    /**
     * Specifies columns axis
     *
     * @param array|Expression $columns
     * @return QueryInterface
     */
    public function select($columns): self;

    /**
     * Specifies rows axis
     *
     * @param array|Expression $rows
     * @return QueryInterface
     */
    public function by($rows): self;

    /**
     * Specifies cube name
     *
     * @param $cube
     * @return QueryInterface
     */
    public function from(string $cube): self;

    /**
     * Adds where clause
     *
     * @param Expression $clause
     * @return QueryInterface
     */
    public function where(Expression $clause): self;

    /**
     * Executes MDX query
     *
     * @return CellSet
     */
    public function execute(): CellSet;

    /**
     * Converts query to raw MDX string
     *
     * @return string
     */
    public function toMDX(): string;

    /**
     * @return array
     */
    public function getColumnAliases(): array;
}