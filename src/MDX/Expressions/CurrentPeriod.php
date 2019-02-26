<?php
declare(strict_types=1);
namespace Vasilisq\MdxQueryBuilder\MDX\Expressions;

use Vasilisq\MdxQueryBuilder\MDX\Period;
use Vasilisq\MdxQueryBuilder\MDX\Expression;

/**
 * Extracts specified current time dimension member, e.g. current quarter
 *
 * @package Vasilisq\MdxQueryBuilder\MDX\Expressions
 */
class CurrentPeriod extends Expression
{
    /**
     * @param int $period
     * @param string $timeDimension
     */
    public function __construct(int $period = Period::YEAR, string $timeDimension = Expression::TIME_DIMENSION)
    {
        $formatString = '[yyyy]';

        if ($period < Period::QUARTER) {
            $formatString .= '.[Qq]';
        }

        if ($period < Period::MONTH) {
            $formatString .= '.[m]';
        }

        if ($period < Period::WEEK) {
            $formatString .= '.[Ww]';
        }

        return parent::__construct("CurrentDateMember([{$timeDimension}], '{$formatString}')");
    }
}