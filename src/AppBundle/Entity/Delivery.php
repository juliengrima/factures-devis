<?php

namespace AppBundle\Entity;

/**
 * Delivery
 */
class Delivery
{
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
}
