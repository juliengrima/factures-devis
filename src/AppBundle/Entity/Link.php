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
     * @var string|null
     */
    private $linkname;

    /**
     * @var string
     */
    private $link;

    /**
     * @var \AppBundle\Entity\SheetDev
     */
    private $sheetdev1;

    /**
     * @var \AppBundle\Entity\Sheet
     */
    private $sheet1;

    /**
     * @var \AppBundle\Entity\Delivery
     */
    private $delivery1;


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
     * Set linkname.
     *
     * @param string|null $linkname
     *
     * @return Link
     */
    public function setLinkname($linkname = null)
    {
        $this->linkname = $linkname;

        return $this;
    }

    /**
     * Get linkname.
     *
     * @return string|null
     */
    public function getLinkname()
    {
        return $this->linkname;
    }

    /**
     * Set link.
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
     * Get link.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set sheetdev1.
     *
     * @param \AppBundle\Entity\SheetDev|null $sheetdev1
     *
     * @return Link
     */
    public function setSheetdev1(\AppBundle\Entity\SheetDev $sheetdev1 = null)
    {
        $this->sheetdev1 = $sheetdev1;

        return $this;
    }

    /**
     * Get sheetdev1.
     *
     * @return \AppBundle\Entity\SheetDev|null
     */
    public function getSheetdev1()
    {
        return $this->sheetdev1;
    }

    /**
     * Set sheet1.
     *
     * @param \AppBundle\Entity\Sheet|null $sheet1
     *
     * @return Link
     */
    public function setSheet1(\AppBundle\Entity\Sheet $sheet1 = null)
    {
        $this->sheet1 = $sheet1;

        return $this;
    }

    /**
     * Get sheet1.
     *
     * @return \AppBundle\Entity\Sheet|null
     */
    public function getSheet1()
    {
        return $this->sheet1;
    }

    /**
     * Set delivery1.
     *
     * @param \AppBundle\Entity\Delivery|null $delivery1
     *
     * @return Link
     */
    public function setDelivery1(\AppBundle\Entity\Delivery $delivery1 = null)
    {
        $this->delivery1 = $delivery1;

        return $this;
    }

    /**
     * Get delivery1.
     *
     * @return \AppBundle\Entity\Delivery|null
     */
    public function getDelivery1()
    {
        return $this->delivery1;
    }
}
