<?php
declare(strict_types=1);
namespace Vasilisq\MdxQueryBuilder;

/**
 * Composite of two CellSets.
 * One is used for header row (summary), another is for detailed view.
 *
 * @package Vasilisq\MdxQueryBuilder
 */
class DataSet
{
    /** @var CellSet */
    protected $detail;

    /** @var CellSet */
    protected $summary;

    /**
     * @param CellSet $detail
     */
    public function __construct(CellSet $detail)
    {
        $this->detail = $detail;
    }

    /**
     * @return CellSet
     */
    public function getDetail(): CellSet
    {
        return $this->detail;
    }

    /**
     * @param CellSet $detail
     * @return $this
     */
    public function setDetail(CellSet $detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return null|CellSet
     */
    public function getSummary(): ?CellSet
    {
        return $this->summary;
    }

    /**
     * @param CellSet $summary
     * @return $this
     */
    public function setSummary(CellSet $summary)
    {
        $this->summary = $summary;

        return $this;
    }
}
