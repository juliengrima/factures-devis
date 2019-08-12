<?php

namespace AppBundle\Entity;

/**
 * Sheet
 */
class Sheet
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $line;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var \AppBundle\Entity\Link
     */
    private $link;

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
     * Set line
     *
     * @param string $line
     *
     * @return Sheet
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * Get line
     *
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Sheet
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set link
     *
     * @param \AppBundle\Entity\Link $link
     *
     * @return Sheet
     */
    public function setLink(\AppBundle\Entity\Link $link = null)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return \AppBundle\Entity\Link
     */
    public function getLink()
    {
        return $this->link;
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
