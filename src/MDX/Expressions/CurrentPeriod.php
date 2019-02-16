<?php

namespace Vasilisq\MdxQueryBuilder\MDX\Expressions;

use Vasilisq\MdxQueryBuilder\MDX\Period;
use Vasilisq\MdxQueryBuilder\MDX\Expression;

class CurrentPeriod extends Expression
{
    public function __construct($period = Period::YEAR, $timeDimension = Expression::TIME_DIMENSION)
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