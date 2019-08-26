<?php

namespace AppBundle\Entity;

/**
 * Link
 */
class Link
{
    private $file;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($picture)
    {
        $this->file = $picture;
        return $this;
    }

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
     * @var integer
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
     * @param integer $sheet
     *
     * @return Link
     */
    public function setSheet($sheet)
    {
        $this->sheet = $sheet;

        return $this;
    }

    /**
     * Get sheet
     *
     * @return integer
     */
    public function getSheet()
    {
        return $this->sheet;
    }
}
