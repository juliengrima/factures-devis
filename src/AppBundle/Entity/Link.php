<?php

namespace AppBundle\Entity;

/**
 * Link
 */
class Link
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $link;


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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Link
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
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
     * @return Link
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
