<?php
declare(strict_types=1);
namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\ConnectionStub;
use Vasilisq\MdxQueryBuilder\CellSet;
use Vasilisq\MdxQueryBuilder\MDX\Exceptions\MalformedMdxQuery;
use Vasilisq\MdxQueryBuilder\MDX\Query;
use Vasilisq\MdxQueryBuilder\MDX\QueryInterface;
use Vasilisq\MdxQueryBuilder\OLAP\ConnectionInterface;

class QueryClassTest extends TestCase
{
    /** @var ConnectionInterface */
    protected $connection;

    /** @var QueryInterface */
    protected $query;

    public function setUp()
    {
        $this->connection = new ConnectionStub();
        $this->query = new Query($this->connection);
    }

    public function testThrowsIfNoColumns()
    {
        $this->query->from('Cube');

        $this->expectExceptionObject(new MalformedMdxQuery('No columns passed!'));

        $this->query->execute();
    }

    public function testThrowsIfNoCube()
    {
        $this->query->select('[Measures].[Profit]');

        $this->expectExceptionObject(new MalformedMdxQuery('No cube selected!'));

        $this->query->execute();
    }

    public function testExecuteSuccess()
    {
        $this->query->withMember('[Member]', '[Measures].[Measure]')
            ->withSet('[Set]', '[Dimensions].Members]')
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by([
                '[Time].[1991].Children',
                '[Time].[1992].Children'
            ])
            ->from('Cube')
            ->where('[Order Payment].[Paid]');

        $this->assertInstanceOf(CellSet::class, $this->query->execute());
    }
}