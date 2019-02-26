<?php
declare(strict_types=1);
namespace Vasilisq\MdxQueryBuilder\MDX;

/**
 * Helper-class to use in various period expressions
 *
 * @package Vasilisq\MdxQueryBuilder\MDX
 */
abstract class Period
{
    public const DAY     = 1;
    public const WEEK    = 2;
    public const MONTH   = 3;
    public const QUARTER = 4;
    public const YEAR    = 5;

    protected const PERIOD_TO_STRING = [
        self::DAY       => 'day',
        self::WEEK      => 'week',
        self::MONTH     => 'month',
        self::QUARTER   => 'quarter',
        self::YEAR      => 'year'
    ];

    /**
     * Coverts string representation of period to constant
     *
     * @param string $period
     *
     * @return int
     *
     * @throws \InvalidArgumentException
     */
    public static function parsePeriodString(string $period): int
    {
        $period = strtolower($period);
        $stringToPeriod = array_flip(static::PERIOD_TO_STRING);

        if (!isset($stringToPeriod[$period])) {
            throw new \InvalidArgumentException('Invalid period given!');
        }

        return $stringToPeriod[$period];
    }

    /**
     * Converts integer representation of period to string
     *
     * @param int $period
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public static function periodToString(int $period): string
    {
        if (!isset(static::PERIOD_TO_STRING[$period])) {
            throw new \InvalidArgumentException('Invalid period given!');
        }

        return static::PERIOD_TO_STRING[$period];
    }
}