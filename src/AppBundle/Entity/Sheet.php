<?php

namespace AppBundle\Entity;

/**
 * Sheet
 */
class Sheet
{

    public function __construct()
    {
//        Give date for ticket
        $this->date = new \DateTime('now');
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->provider . $this->years . $this->facture ;
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $facture;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $years;

    /**
     * @var \AppBundle\Entity\Provider
     */
    private $provider;

    /**
     * @var \AppBundle\Entity\SheetDev
     */
    private $sheetdev;


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
     * Set facture
     *
     * @param boolean $facture
     *
     * @return Sheet
     */
    public function setFacture($facture)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return boolean
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Sheet
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set years
     *
     * @param string $years
     *
     * @return Sheet
     */
    public function setYears($years)
    {
        $this->years = $years;

        return $this;
    }

    /**
     * Get years
     *
     * @return string
     */
    public function getYears()
    {
        return $this->years;
    }

    /**
     * Set provider
     *
     * @param \AppBundle\Entity\Provider $provider
     *
     * @return Sheet
     */
    public function setProvider(\AppBundle\Entity\Provider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return \AppBundle\Entity\Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set sheetdev
     *
     * @param \AppBundle\Entity\SheetDev $sheetdev
     *
     * @return Sheet
     */
    public function setSheetdev(\AppBundle\Entity\SheetDev $sheetdev = null)
    {
        $this->sheetdev = $sheetdev;

        return $this;
    }

    /**
     * Get sheetdev
     *
     * @return \AppBundle\Entity\SheetDev
     */
    public function getSheetdev()
    {
        return $this->sheetdev;
    }
}
