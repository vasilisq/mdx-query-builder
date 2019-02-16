<?php

namespace Vasilisq\MdxQueryBuilder\MDX;

use Vasilisq\MdxQueryBuilder\CellSet;

interface QueryInterface
{
    public function withMember(string $alias, Expression $expression, ?string $formatString = null): self;

    public function withSet(string $alias, Expression $expression): self;

    public function select($columns): self;

    public function by($rows): self;

    public function from($cube): self;

    public function where($clause): self;

    public function execute(): CellSet;

    public function toMDX(): string;

    public function getColumnAliases(): array;
}