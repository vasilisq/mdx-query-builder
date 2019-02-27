<?php
declare(strict_types=1);
namespace Tests;

use PHPUnit\Framework\TestCase;
use Vasilisq\MdxQueryBuilder\MDX\Period;

class PeriodTest extends TestCase
{
    protected $periods = [
        'day',
        'week',
        'month',
        'quarter',
        'year'
    ];

    public function testParsePeriodString()
    {
        foreach ($this->periods as $idx => $period) {
            $this->assertEquals($idx +1, Period::parsePeriodString(ucfirst($period)));
        }
    }

    public function testPeriodToString()
    {
        foreach ($this->periods as $idx => $period) {
            $this->assertEquals(Period::periodToString($idx + 1), $period);
        }
    }
}