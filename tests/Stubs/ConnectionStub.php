<?php
declare(strict_types=1);
namespace Tests\Stubs;

use Vasilisq\MdxQueryBuilder\CellSet;
use Vasilisq\MdxQueryBuilder\MDX\QueryInterface;
use Vasilisq\MdxQueryBuilder\OLAP\ConnectionInterface;

class ConnectionStub implements ConnectionInterface
{
    public function executeQuery(QueryInterface $query): CellSet
    {
        $query->toMDX();

        return new CellSet();
    }
}