<?php

namespace Vasilisq\MdxQueryBuilder\OLAP;

use Vasilisq\MdxQueryBuilder\CellSet;
use Vasilisq\MdxQueryBuilder\MDX\QueryInterface;

/**
 * OLAP Connection interface
 *
 * @package Vasilisq\MdxQueryBuilder\OLAP
 */
interface ConnectionInterface
{
    /**
     * @param QueryInterface $query
     * @return CellSet
     */
    public function executeQuery(QueryInterface $query): CellSet;
}