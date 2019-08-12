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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $contact;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sheet;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contact = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sheet = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add contact
     *
     * @param \AppBundle\Entity\Contact $contact
     *
     * @return society
     */
    public function addContact(\AppBundle\Entity\Contact $contact)
    {
        $this->contact[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \AppBundle\Entity\Contact $contact
     */
    public function removeContact(\AppBundle\Entity\Contact $contact)
    {
        $this->contact->removeElement($contact);
    }

    /**
     * Get contact
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Add sheet
     *
     * @param \AppBundle\Entity\Sheet $sheet
     *
     * @return society
     */
    public function addSheet(\AppBundle\Entity\Sheet $sheet)
    {
        $this->sheet[] = $sheet;

        return $this;
    }

    /**
     * Remove sheet
     *
     * @param \AppBundle\Entity\Sheet $sheet
     */
    public function removeSheet(\AppBundle\Entity\Sheet $sheet)
    {
        $this->sheet->removeElement($sheet);
    }

    /**
     * Get sheet
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSheet()
    {
        return $this->sheet;
    }
}
