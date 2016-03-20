<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="plans")
 */
class Plan
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $total_flyers;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $total_emails;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $total_contacts;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $is_public;


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
     * Set name
     *
     * @param string $name
     * @return Plan
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set total_flyers
     *
     * @param integer $totalFlyers
     * @return Plan
     */
    public function setTotalFlyers($totalFlyers)
    {
        $this->total_flyers = $totalFlyers;

        return $this;
    }

    /**
     * Get total_flyers
     *
     * @return integer 
     */
    public function getTotalFlyers()
    {
        return $this->total_flyers;
    }

    /**
     * Set total_emails
     *
     * @param integer $totalEmails
     * @return Plan
     */
    public function setTotalEmails($totalEmails)
    {
        $this->total_emails = $totalEmails;

        return $this;
    }

    /**
     * Get total_emails
     *
     * @return integer 
     */
    public function getTotalEmails()
    {
        return $this->total_emails;
    }

    /**
     * Set total_contacts
     *
     * @param integer $totalContacts
     * @return Plan
     */
    public function setTotalContacts($totalContacts)
    {
        $this->total_contacts = $totalContacts;

        return $this;
    }

    /**
     * Get total_contacts
     *
     * @return integer 
     */
    public function getTotalContacts()
    {
        return $this->total_contacts;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Plan
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
     * Set is_public
     *
     * @param boolean $isPublic
     * @return Plan
     */
    public function setIsPublic($isPublic)
    {
        $this->is_public = $isPublic;

        return $this;
    }

    /**
     * Get is_public
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->is_public;
    }
}
