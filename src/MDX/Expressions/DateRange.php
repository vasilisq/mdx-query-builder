<?php

namespace Vasilisq\MdxQueryBuilder\MDX\Expressions;

use Carbon\Carbon;
use Vasilisq\MdxQueryBuilder\MDX\Period;
use Vasilisq\MdxQueryBuilder\MDX\Expression;

class DateRange extends Expression
{
    /** @var int */
    protected $drilldown;

    /** @var string */
    protected $dimension;

    /** @var Carbon */
    protected $start;

    /** @var Carbon */
    protected $end;

    public function __construct(
        Carbon $startDate,
        Carbon $endDate,
        $drilldown = Period::DAY,
        $timeDimension = Expression::TIME_DIMENSION
    ) {
        $this->dimension = $timeDimension;
        $this->drilldown = $drilldown;
        $this->start = $startDate;
        $this->end = $endDate;

        $startTimeMember = $this->carbonToTimeMember($this->start);
        $endTimeMember = $this->carbonToTimeMember($this->end);

        return parent::__construct("{{$startTimeMember} : {$endTimeMember}}");
    }

    protected function carbonToTimeMember(Carbon $date)
    {
        $memberString = "[{$date->year}]";

        if ($this->drilldown <= Period::QUARTER) {
            $memberString .= ".[Q{$date->quarter}]";
        }

        if ($this->drilldown <= Period::MONTH) {
            $memberString .= ".[{$date->month}]";
        }

        if ($this->drilldown <= Period::WEEK) {
            $memberString .= ".[W{$date->weekOfYear}]";
        }

        if ($this->drilldown === Period::DAY) {
            $memberString .= ".[D{$date->day}]";
        }

        return "[{$this->dimension}].{$memberString}";
    }

    /**
     * @return int
     */
    public function getDrilldown(): int
    {
        return $this->drilldown;
    }

    /**
     * @return string
     */
    public function getDimension(): string
    {
        return $this->dimension;
    }

    /**
     * @return Carbon
     */
    public function getStart(): Carbon
    {
        return $this->start;
    }

    /**
     * @return Carbon
     */
    public function getEnd(): Carbon
    {
        return $this->end;
    }
}