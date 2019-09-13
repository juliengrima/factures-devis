<?php

namespace AppBundle\Entity;

/**
 * society
 */
class society
{

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->societyName;
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $societyName;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $zipcode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sheetdev;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sheetdev = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set societyName
     *
     * @param string $societyName
     *
     * @return society
     */
    public function setSocietyName($societyName)
    {
        $this->societyName = $societyName;

        return $this;
    }

    /**
     * Get societyName
     *
     * @return string
     */
    public function getSocietyName()
    {
        return $this->societyName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return society
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param integer $zipcode
     *
     * @return society
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return integer
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return society
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return society
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Add sheetdev
     *
     * @param \AppBundle\Entity\SheetDev $sheetdev
     *
     * @return society
     */
    public function addSheetdev(\AppBundle\Entity\SheetDev $sheetdev)
    {
        $this->sheetdev[] = $sheetdev;

        return $this;
    }

    /**
     * Remove sheetdev
     *
     * @param \AppBundle\Entity\SheetDev $sheetdev
     */
    public function removeSheetdev(\AppBundle\Entity\SheetDev $sheetdev)
    {
        $this->sheetdev->removeElement($sheetdev);
    }

    /**
     * Get sheetdev
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSheetdev()
    {
        return $this->sheetdev;
    }
}
