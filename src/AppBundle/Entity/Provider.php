<?php

namespace AppBundle\Entity;

/**
 * Provider
 */
class Provider
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $provider;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $contact;


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
     * Set provider
     *
     * @param string $provider
     *
     * @return Provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Provider
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Provider
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
}
