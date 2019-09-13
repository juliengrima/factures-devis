<?php

namespace AppBundle\Entity;

/**
 * Years
 */
class Years
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $years;


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
     * @return int
     */
    public function getYears()
    {
        return $this->years;
    }
}

