<?php
declare(strict_types=1);
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
     * @param string|Expression $expression
     * @param null|string $formatString
     * @return QueryInterface
     */
    public function withMember(string $alias, $expression, ?string $formatString = null): self;

    /**
     * Adds set to WITH clause
     *
     * @param string $alias
     * @param string|Expression $expression
     * @return QueryInterface
     */
    public function withSet(string $alias, $expression): self;

    /**
     * Specifies columns axis
     *
     * @param array|Expression|string $columns
     * @return QueryInterface
     */
    public function select($columns): self;

    /**
     * Specifies rows axis
     *
     * @param array|Expression|string $rows
     * @return QueryInterface
     */
    public function by($rows): self;

    /**
     * Specifies cube name
     *
     * @param string $cube
     * @return QueryInterface
     */
    public function from(string $cube): self;

    /**
     * Adds where clause
     *
     * @param array|Expression|string $clause
     * @return QueryInterface
     */
    public function where($clause): self;

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
}