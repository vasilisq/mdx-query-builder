<?php

namespace Vasilisq\MdxQueryBuilder\MDX\Expressions;

use Vasilisq\MdxQueryBuilder\MDX\Period;
use Vasilisq\MdxQueryBuilder\MDX\Expression;

class Descendants extends Expression
{
    /**
     * @param string|Expression $expression
     * @param int $level
     */
    public function __construct($expression, $level = null)
    {
        $expr = "Descendants({$expression}";

        if (! is_null($level)) {
            $expr .= ", [{$this->periodToLevel($level)}])";
        } else {
            $expr .= ')';
        }

        parent::__construct($expr);
    }

    protected function periodToLevel($period)
    {
        return ucfirst(Period::periodToString($period));
    }
}