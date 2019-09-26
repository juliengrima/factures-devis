<?php

namespace AppBundle\Entity;

/**
 * Years
 */
class Years
{
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->years;
    }


    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $years;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set years
     *
     * @param integer $years
     *
     * @return Years
     */
    public function setYears($years)
    {
        $this->years = $years;

        return $this;
    }

    /**
     * Get years
     *
     * @return integer
     */
    public function getYears()
    {
        return $this->years;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sheetdev;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sheetdev = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sheetdev
     *
     * @param \AppBundle\Entity\SheetDev $sheetdev
     *
     * @return Years
     */
    public function addSheetdev(\AppBundle\Entity\SheetDev $sheetdev)
    {
        $this->sheetdev[] = $sheetdev;

        return $this;
    }

    /**
     * Remove sheetdev
     *
     * @param \AppBundle\Entity\SheetDev $sheetdev
     */
    public function removeSheetdev(\AppBundle\Entity\SheetDev $sheetdev)
    {
        $this->sheetdev->removeElement($sheetdev);
    }

    /**
     * Get sheetdev
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSheetdev()
    {
        return $this->sheetdev;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sheet;


    /**
     * Add sheet
     *
     * @param \AppBundle\Entity\SheetDev $sheet
     *
     * @return Years
     */
    public function addSheet(\AppBundle\Entity\SheetDev $sheet)
    {
        $this->sheet[] = $sheet;

        return $this;
    }

    /**
     * Remove sheet
     *
     * @param \AppBundle\Entity\SheetDev $sheet
     */
    public function removeSheet(\AppBundle\Entity\SheetDev $sheet)
    {
        $this->sheet->removeElement($sheet);
    }

    /**
     * Get sheet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSheet()
    {
        return $this->sheet;
    }
}
