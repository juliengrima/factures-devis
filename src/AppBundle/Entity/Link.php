<?php

namespace AppBundle\Entity;

/**
 * Link
 */
class Link
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $linkname;

    /**
     * @var string
     */
    private $link;

    /**
     * @var \AppBundle\Entity\Sheet
     */
    private $sheet;


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
     * Set linkname
     *
     * @param string $linkname
     *
     * @return Link
     */
    public function setLinkname($linkname)
    {
        $this->linkname = $linkname;

        return $this;
    }

    /**
     * Get linkname
     *
     * @return string
     */
    public function getLinkname()
    {
        return $this->linkname;
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
     * Set sheet
     *
     * @param \AppBundle\Entity\Sheet $sheet
     *
     * @return Link
     */
    public function setSheet(\AppBundle\Entity\Sheet $sheet = null)
    {
        $this->sheet = $sheet;

        return $this;
    }

    /**
     * Get sheet
     *
     * @return \AppBundle\Entity\Sheet
     */
    public function getSheet()
    {
        return $this->sheet;
    }
}
