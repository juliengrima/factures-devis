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
     * @var int
     */
    private $id;

    /**
     * @var bool|null
     */
    private $devis;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $years;

    /**
     * @var \AppBundle\Entity\Link
     */
    private $link1;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sheet;

    /**
     * @var \AppBundle\Entity\society
     */
    private $society;


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
     * Set devis.
     *
     * @param bool|null $devis
     *
     * @return SheetDev
     */
    public function setDevis($devis = null)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis.
     *
     * @return bool|null
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set date.
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
     * @return SheetDev
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
     * Set link1.
     *
     * @param \AppBundle\Entity\Link|null $link1
     *
     * @return SheetDev
     */
    public function setLink1(\AppBundle\Entity\Link $link1 = null)
    {
        $this->link1 = $link1;

        return $this;
    }

    /**
     * Get link1.
     *
     * @return \AppBundle\Entity\Link|null
     */
    public function getLink1()
    {
        return $this->link1;
    }

    /**
     * Add sheet.
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
     * Remove sheet.
     *
     * @param \AppBundle\Entity\Sheet $sheet
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSheet(\AppBundle\Entity\Sheet $sheet)
    {
        return $this->sheet->removeElement($sheet);
    }

    /**
     * Get sheet.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSheet()
    {
        return $this->sheet;
    }

    /**
     * Set society.
     *
     * @param \AppBundle\Entity\society|null $society
     *
     * @return SheetDev
     */
    public function setSociety(\AppBundle\Entity\society $society = null)
    {
        $this->society = $society;

        return $this;
    }

    /**
     * Get society.
     *
     * @return \AppBundle\Entity\society|null
     */
    public function getSociety()
    {
        return $this->society;
    }
}
