<?php
declare(strict_types=1);
namespace Vasilisq\MdxQueryBuilder\MDX;

/**
 * Class Expression
 *
 * @package Vasilisq\MdxQueryBuilder\MDX
 */
abstract class Expression
{
    public const TIME_DIMENSION = 'Time';

    /** @var string */
    protected $expression;

    public function __construct(string $expression)
    {
        $this->expression = $expression;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function __toString(): string
    {
        return $this->expression;
    }
}
