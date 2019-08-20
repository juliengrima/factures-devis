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
        return $this->date;
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
     * Set society
     *
     * @param \AppBundle\Entity\society $society
     *
     * @return Sheet
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
