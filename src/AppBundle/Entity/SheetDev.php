<?php

namespace AppBundle\Entity;

/**
 * SheetDev
 */
class SheetDev
{
    public function __construct()
    {
//        Give date for ticket
        $this->date = new \DateTime('now');
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->society . $this->devis . $this->years . $this->id;
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $devis;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $years;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sheet;

    /**
     * @var \AppBundle\Entity\society
     */
    private $society;


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
     * Set devis
     *
     * @param boolean $devis
     *
     * @return SheetDev
     */
    public function setDevis($devis)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis
     *
     * @return boolean
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return SheetDev
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
     * @param integer $years
     *
     * @return SheetDev
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
     * Add sheet
     *
     * @param \AppBundle\Entity\Sheet $sheet
     *
     * @return SheetDev
     */
    public function addSheet(\AppBundle\Entity\Sheet $sheet)
    {
        $this->sheet[] = $sheet;

        return $this;
    }

    /**
     * Remove sheet
     *
     * @param \AppBundle\Entity\Sheet $sheet
     */
    public function removeSheet(\AppBundle\Entity\Sheet $sheet)
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

    /**
     * Set society
     *
     * @param \AppBundle\Entity\society $society
     *
     * @return SheetDev
     */
    public function setSociety(\AppBundle\Entity\society $society = null)
    {
        $this->society = $society;

        return $this;
    }

    /**
     * Get society
     *
     * @return \AppBundle\Entity\society
     */
    public function getSociety()
    {
        return $this->society;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $delivery;


    /**
     * Add delivery.
     *
     * @param \AppBundle\Entity\Delivery $delivery
     *
     * @return SheetDev
     */
    public function addDelivery(\AppBundle\Entity\Delivery $delivery)
    {
        $this->delivery[] = $delivery;

        return $this;
    }

    /**
     * Remove delivery.
     *
     * @param \AppBundle\Entity\Delivery $delivery
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDelivery(\AppBundle\Entity\Delivery $delivery)
    {
        return $this->delivery->removeElement($delivery);
    }

    /**
     * Get delivery.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDelivery()
    {
        return $this->delivery;
    }
}
