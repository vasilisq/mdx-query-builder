<?php

namespace Vasilisq\MdxQueryBuilder\MDX;

abstract class Expression
{
    public const PERIOD_DAY = 1;
    public const PERIOD_WEEK = 2;
    public const PERIOD_MONTH = 3;
    public const PERIOD_QUARTER = 4;
    public const PERIOD_YEAR = 5;

    public const TIME_DIMENSION = 'Time';

    public const PERIOD_TO_STRING = [
        self::PERIOD_DAY => 'day',
        self::PERIOD_WEEK => 'week',
        self::PERIOD_MONTH => 'month',
        self::PERIOD_QUARTER => 'quarter',
        self::PERIOD_YEAR => 'year',
    ];

    protected $expression;

    public function __construct(string $expression)
    {
        $this->expression = $expression;
    }

    public static function parsePeriodString(string $period): int
    {
        $period = strtolower($period);
        $stringToPeriod = array_flip(static::PERIOD_TO_STRING);

        if (!isset($stringToPeriod[$period])) {
            throw new \InvalidArgumentException('Invalid period given!');
        }

        return $stringToPeriod[$period];
    }

    public function getExpression()
    {
        return $this->expression;
    }

    public function __toString()
    {
        return $this->expression;
    }
}
