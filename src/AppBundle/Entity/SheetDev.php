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
        return $this->society . $this->devis . $this->years;
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $devis;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sheet;

    /**
     * @var \AppBundle\Entity\Years
     */
    private $years;

    /**
     * @var \AppBundle\Entity\society
     */
    private $society;


    /**
     * Get id
     *
     * @return int
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
     * @return bool
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
     * Set years
     *
     * @param \AppBundle\Entity\Years $years
     *
     * @return SheetDev
     */
    public function setYears(\AppBundle\Entity\Years $years = null)
    {
        $this->years = $years;

        return $this;
    }

    /**
     * Get years
     *
     * @return \AppBundle\Entity\Years
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
}
