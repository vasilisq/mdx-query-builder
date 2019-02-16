<?php

namespace Vasilisq\MdxQueryBuilder;

class DataSet
{
    /** @var CellSet */
    protected $detail;

    /** @var CellSet */
    protected $summary;

    public function __construct(CellSet $detail)
    {
        $this->detail = $detail;
    }

    public function getDetail(): CellSet
    {
        return $this->detail;
    }

    public function setDetail(CellSet $detail)
    {
        $this->detail = $detail;

        return $this;
    }

    public function getSummary(): ?CellSet
    {
        return $this->summary;
    }

    public function setSummary(CellSet $summary)
    {
        $this->summary = $summary;

        return $this;
    }
}
