<?php

namespace Vasilisq\MdxQueryBuilder;

class CellSet
{
    /** @var array */
    protected $columns;

    /** @var array */
    protected $rows;

    public function __construct(array $columns = [], array $rows = [])
    {
        $this->columns = $columns;
        $this->rows = $rows;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function addColumn(string $column)
    {
        $this->columns[] = $column;

        return $this;
    }

    public function addRow(array $row)
    {
        $this->rows[] = $row;

        return $this;
    }
}
