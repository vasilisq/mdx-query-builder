<?php
declare(strict_types=1);
namespace Tests\Expressions;

use PHPUnit\Framework\TestCase;
use Vasilisq\MdxQueryBuilder\MDX\Expressions\Descendants;
use Vasilisq\MdxQueryBuilder\MDX\Expressions\Raw;
use Vasilisq\MdxQueryBuilder\MDX\Period;

class DescendantsTest extends TestCase
{
    public function testExpression()
    {
        $dimension = new Raw('[Time]');

        $this->assertEquals('Descendants([Time])', new Descendants($dimension));
    }

    public function testWithLevels()
    {
        $dimension = new Raw('[Time]');

        $levels = [
            Period::DAY,
            Period::WEEK,
            Period::MONTH,
            Period::QUARTER,
            Period::YEAR
        ];

        foreach ($levels as $level) {
            $this->assertEquals(
                'Descendants([Time], [' . ucfirst(Period::periodToString($level)) . '])',
                new Descendants($dimension, $level)
            );
        }
    }
}