<?php

namespace AppBundle\Entity;

/**
 * Years
 */
class Years
{
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->years;
    }


    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $years;


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
     * @return integer
     */
    public function getYears()
    {
        return $this->years;
    }
}
