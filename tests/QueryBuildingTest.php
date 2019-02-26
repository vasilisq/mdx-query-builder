<?php
declare(strict_types=1);
namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\ConnectionStub;
use Vasilisq\MdxQueryBuilder\MDX\Query;
use Vasilisq\MdxQueryBuilder\MDX\QueryInterface;
use Vasilisq\MdxQueryBuilder\MDX\Expressions\Raw;
use Vasilisq\MdxQueryBuilder\OLAP\ConnectionInterface;

class QueryBuildingTest extends TestCase
{
    /** @var ConnectionInterface */
    protected $connection;

    /** @var QueryInterface */
    protected $query;

    /** @var string */
    protected $expectedMdx;

    public function setUp()
    {
        $this->connection = new ConnectionStub();
        $this->query = new Query($this->connection);
    }

    public function tearDown()
    {
        $this->assertEqualsIgnoringCase($this->expectedMdx, $this->query->toMDX());
    }

    public function testCorrectSelectStatement()
    {
        $this->query
            ->select('[Measures].[Profit]')
            ->from('Cube');

        $this->expectedMdx = 'SELECT {[Measures].[Profit]} ON COLUMNS FROM [Cube]';
    }

    public function testCorrectMultipleColumnsStatement()
    {
        $this->query
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->from('Cube');

        $this->expectedMdx = 'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS FROM [Cube]';
    }

    public function testCorrectRowsStatement()
    {
        $this->query
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by('[Time].[1991]')
            ->from('Cube');

        $this->expectedMdx = 'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS, ' .
            '{[Time].[1991]} ON ROWS FROM [Cube]';
    }

    public function testCorrectMultipleRowsStatement()
    {
        $this->query
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by([
                '[Time].[1991]',
                '[Time].[1992]'
            ])
            ->from('Cube');

        $this->expectedMdx = 'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS, ' .
            '{[Time].[1991], [Time].[1992]} ON ROWS FROM [Cube]';
    }

    public function testCorrectSlicerStatement()
    {
        $this->query
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by([
                '[Time].[1991]',
                '[Time].[1992]'
            ])
            ->where('[Order Payment].[Paid]')
            ->from('Cube');

        $this->expectedMdx = 'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS, ' .
            '{[Time].[1991], [Time].[1992]} ON ROWS ' .
            'FROM [Cube] ' .
            'WHERE [Order Payment].[Paid]';
    }

    public function testCorrectMultipleSlicersStatement()
    {
        $this->query
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by([
                '[Time].[1991]',
                '[Time].[1992]'
            ])
            ->where([
                '[Order Payment].[Paid]',
                '[Order Process].[Delivered]'
            ])
            ->from('Cube');

        $this->expectedMdx = 'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS, ' .
            '{[Time].[1991], [Time].[1992]} ON ROWS ' .
            'FROM [Cube] ' .
            'WHERE [Order Payment].[Paid] * [Order Process].[Delivered]';
    }

    public function testCorrectWithMemberStatement()
    {
        $this->query
            ->withMember('[Member1]', new Raw('[Measures].[CM]'))
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by([
                '[Time].[1991]',
                '[Time].[1992]'
            ])
            ->where([
                '[Order Payment].[Paid]',
                '[Order Process].[Delivered]'
            ])
            ->from('Cube');

        $this->expectedMdx = 'WITH MEMBER [Member1] AS [Measures].[CM] ' .
            'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS, ' .
            '{[Time].[1991], [Time].[1992]} ON ROWS ' .
            'FROM [Cube] ' .
            'WHERE [Order Payment].[Paid] * [Order Process].[Delivered]';
    }

    public function testCorrectWithMembersStatement()
    {
        $this->query
            ->withMember('[Member1]', new Raw('[Measures].[CM]'))
            ->withMember('[Member2]', new Raw('[Measures].[CM2]'))
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by([
                '[Time].[1991]',
                '[Time].[1992]'
            ])
            ->where([
                '[Order Payment].[Paid]',
                '[Order Process].[Delivered]'
            ])
            ->from('Cube');

        $this->expectedMdx = 'WITH MEMBER [Member1] AS [Measures].[CM] ' .
            'MEMBER [Member2] AS [Measures].[CM2] ' .
            'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS, ' .
            '{[Time].[1991], [Time].[1992]} ON ROWS ' .
            'FROM [Cube] ' .
            'WHERE [Order Payment].[Paid] * [Order Process].[Delivered]';
    }

    public function testCorrectWithSetStatement()
    {
        $this->query
            ->withSet('[Set1]', new Raw('[Dimension].Members'))
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by([
                '[Time].[1991]',
                '[Time].[1992]'
            ])
            ->where([
                '[Order Payment].[Paid]',
                '[Order Process].[Delivered]'
            ])
            ->from('Cube');

        $this->expectedMdx = 'WITH SET [Set1] AS [Dimension].Members ' .
            'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS, ' .
            '{[Time].[1991], [Time].[1992]} ON ROWS ' .
            'FROM [Cube] ' .
            'WHERE [Order Payment].[Paid] * [Order Process].[Delivered]';
    }

    public function testCorrectWithSetsMembersStatement()
    {
        $this->query
            ->withMember('[Member1]', new Raw('[Measures].[CM]'))
            ->withMember('[Member2]', new Raw('[Measures].[CM2]'))
            ->withSet('[Set1]', new Raw('[Dimension].Members'))
            ->withSet('[Set2]', new Raw('[Dimension2].Members'))
            ->select([
                '[Measures].[Profit]',
                '[Measures].[Retail Total]'
            ])
            ->by([
                '[Time].[1991]',
                '[Time].[1992]'
            ])
            ->where([
                '[Order Payment].[Paid]',
                '[Order Process].[Delivered]'
            ])
            ->from('Cube');

        $this->expectedMdx = 'WITH ' .
            'MEMBER [Member1] AS [Measures].[CM] ' .
            'MEMBER [Member2] AS [Measures].[CM2] ' .
            'SET [Set1] AS [Dimension].Members ' .
            'SET [Set2] AS [Dimension2].Members ' .
            'SELECT {[Measures].[Profit], [Measures].[Retail Total]} ON COLUMNS, ' .
            '{[Time].[1991], [Time].[1992]} ON ROWS ' .
            'FROM [Cube] ' .
            'WHERE [Order Payment].[Paid] * [Order Process].[Delivered]';
    }
}