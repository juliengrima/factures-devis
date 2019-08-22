<?php

namespace AppBundle\Entity;

/**
 * SheetDev
 */
class SheetDev
{
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
     * @var \AppBundle\Entity\society
     */
    private $society;


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
}
