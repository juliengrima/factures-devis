<?php

namespace AppBundle\Entity;

/**
 * Delivery
 */
class Delivery
{
    public function __construct()
    {
//        Give date for ticket
        $this->date = new \DateTime('now');
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->delivery . $this->sheet . $this->years . $this->id;
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var bool|null
     */
    private $delivery;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $years;

    /**
     * @var \AppBundle\Entity\SheetDev
     */
    private $sheetdev;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set delivery.
     *
     * @param bool|null $delivery
     *
     * @return Delivery
     */
    public function setDelivery($delivery = null)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery.
     *
     * @return bool|null
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Delivery
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set years.
     *
     * @param string $years
     *
     * @return Delivery
     */
    public function setYears($years)
    {
        $this->years = $years;

        return $this;
    }

    /**
     * Get years.
     *
     * @return string
     */
    public function getYears()
    {
        return $this->years;
    }

    /**
     * Set sheetdev.
     *
     * @param \AppBundle\Entity\SheetDev|null $sheetdev
     *
     * @return Delivery
     */
    public function setSheetdev(\AppBundle\Entity\SheetDev $sheetdev = null)
    {
        $this->sheetdev = $sheetdev;

        return $this;
    }

    /**
     * Get sheetdev.
     *
     * @return \AppBundle\Entity\SheetDev|null
     */
    public function getSheetdev()
    {
        return $this->sheetdev;
    }
    /**
     * @var \AppBundle\Entity\Sheet
     */
    private $sheet;


    /**
     * Set sheet.
     *
     * @param \AppBundle\Entity\Sheet|null $sheet
     *
     * @return Delivery
     */
    public function setSheet(\AppBundle\Entity\Sheet $sheet = null)
    {
        $this->sheet = $sheet;

        return $this;
    }

    /**
     * Get sheet.
     *
     * @return \AppBundle\Entity\Sheet|null
     */
    public function getSheet()
    {
        return $this->sheet;
    }
    /**
     * @var \AppBundle\Entity\Link
     */
    private $link3;


    /**
     * Set link3.
     *
     * @param \AppBundle\Entity\Link|null $link3
     *
     * @return Delivery
     */
    public function setLink3(\AppBundle\Entity\Link $link3 = null)
    {
        $this->link3 = $link3;

        return $this;
    }

    /**
     * Get link3.
     *
     * @return \AppBundle\Entity\Link|null
     */
    public function getLink3()
    {
        return $this->link3;
    }
}
