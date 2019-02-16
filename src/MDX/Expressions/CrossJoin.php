<?php

namespace Vasilisq\MdxQueryBuilder\MDX\Expressions;

use Vasilisq\MdxQueryBuilder\MDX\Expression;

class CrossJoin extends Expression
{
    public function __construct(Expression $setA, Expression $setB)
    {
        parent::__construct("Crossjoin($setA, $setB)");
    }
}