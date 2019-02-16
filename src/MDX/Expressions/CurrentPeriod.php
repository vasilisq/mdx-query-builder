<?php

namespace Vasilisq\MdxQueryBuilder\MDX\Expressions;

use Vasilisq\MdxQueryBuilder\MDX\Expression;

class CurrentPeriod extends Expression
{
    public function __construct($period = Expression::PERIOD_YEAR, $timeDimension = Expression::TIME_DIMENSION)
    {
        $formatString = '[yyyy]';

        if ($period < static::PERIOD_QUARTER) {
            $formatString .= '.[Qq]';
        }

        if ($period < static::PERIOD_MONTH) {
            $formatString .= '.[m]';
        }

        if ($period < static::PERIOD_WEEK) {
            $formatString .= '.[Ww]';
        }

        return parent::__construct("CurrentDateMember([{$timeDimension}], '{$formatString}')");
    }
}