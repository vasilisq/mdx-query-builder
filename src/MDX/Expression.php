<?php

namespace Vasilisq\MdxQueryBuilder\MDX;

/**
 * Class Expression
 *
 * @package Vasilisq\MdxQueryBuilder\MDX
 */
abstract class Expression
{
    // todo: move somewhere
    public const TIME_DIMENSION = 'Time';

    /** @var string */
    protected $expression;

    public function __construct(string $expression)
    {
        $this->expression = $expression;
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
