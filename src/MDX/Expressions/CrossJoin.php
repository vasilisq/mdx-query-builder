<?php

namespace Vasilisq\MdxQueryBuilder\MDX\Expressions;

use Vasilisq\MdxQueryBuilder\MDX\Expression;

/**
 * CrossJoin expression
 *
 * @package Vasilisq\MdxQueryBuilder\MDX\Expressions
 */
class CrossJoin extends Expression
{
    /**
     * @param Expression $setA
     * @param Expression $setB
     */
    public function __construct(Expression $setA, Expression $setB)
    {
        parent::__construct("Crossjoin($setA, $setB)");
    }
}