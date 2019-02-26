<?php
declare(strict_types=1);
namespace Vasilisq\MdxQueryBuilder\MDX\Expressions;

use Vasilisq\MdxQueryBuilder\MDX\Period;
use Vasilisq\MdxQueryBuilder\MDX\Expression;

/**
 * Descendants by time dimension
 *
 * @package Vasilisq\MdxQueryBuilder\MDX\Expressions
 */
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

    /**
     * @param int $period
     * @return string
     */
    protected function periodToLevel(int $period): string
    {
        return ucfirst(Period::periodToString($period));
    }
}