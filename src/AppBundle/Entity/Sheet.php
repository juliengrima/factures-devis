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
        return $this->provider . $this->years . $this->facture . $this->sheetdev ;
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var bool|null
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
     * @var \AppBundle\Entity\Link
     */
    private $link2;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $delivery;

    /**
     * @var \AppBundle\Entity\Provider
     */
    private $provider;

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
     * Set facture.
     *
     * @param bool|null $facture
     *
     * @return Sheet
     */
    public function setFacture($facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture.
     *
     * @return bool|null
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set date.
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
     * @return Sheet
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
     * Set link2.
     *
     * @param \AppBundle\Entity\Link|null $link2
     *
     * @return Sheet
     */
    public function setLink2(\AppBundle\Entity\Link $link2 = null)
    {
        $this->link2 = $link2;

        return $this;
    }

    /**
     * Get link2.
     *
     * @return \AppBundle\Entity\Link|null
     */
    public function getLink2()
    {
        return $this->link2;
    }

    /**
     * Add delivery.
     *
     * @param \AppBundle\Entity\Delivery $delivery
     *
     * @return Sheet
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

    /**
     * Set provider.
     *
     * @param \AppBundle\Entity\Provider|null $provider
     *
     * @return Sheet
     */
    public function setProvider(\AppBundle\Entity\Provider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider.
     *
     * @return \AppBundle\Entity\Provider|null
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set sheetdev.
     *
     * @param \AppBundle\Entity\SheetDev|null $sheetdev
     *
     * @return Sheet
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
}
