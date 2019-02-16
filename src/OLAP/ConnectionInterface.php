<?php

namespace Vasilisq\MdxQueryBuilder\OLAP;

use Vasilisq\MdxQueryBuilder\CellSet;
use Vasilisq\MdxQueryBuilder\MDX\QueryInterface;

interface ConnectionInterface
{
    public function executeQuery(QueryInterface $query): CellSet;
}