<?php

namespace Vasilisq\MdxQueryBuilder;

/**
 * Represents MDX "table result"
 *
 * @package Vasilisq\MdxQueryBuilder
 */
class CellSet
{
    /** @var array */
    protected $columns;

    /** @var array */
    protected $rows;

    /**
     * @param array $columns
     * @param array $rows
     */
    public function __construct(array $columns = [], array $rows = [])
    {
        $this->columns = $columns;
        $this->rows = $rows;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @param string $column
     * @return CellSet
     */
    public function addColumn(string $column): self
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * @param array $row
     * @return CellSet
     */
    public function addRow(array $row): self
    {
        $this->rows[] = $row;

        return $this;
    }
}
