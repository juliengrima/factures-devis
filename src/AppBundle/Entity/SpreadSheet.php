<?php

namespace AppBundle\Entity;

/**
 * SpreadSheet
 */
class SpreadSheet
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
     * @return SpreadSheet
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
     * @return SpreadSheet
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
}
