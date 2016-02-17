<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="properties")
 */
class Property
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $forRent;

    /**
     * @ORM\Column(type="string")
     */
    protected $leaseTerm;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $bedrooms;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $bathsFull;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $bathsHalf;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $laundry;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $view;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $lotSize;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $yearBuilt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $accessibility;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $mlsId;

    /**
     * @ORM\Column(type="string")
     */
    protected $address;

    /**
     * @ORM\Column(type="string")
     */
    protected $unit;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="string")
     */
    protected $state;

    /**
     * @ORM\Column(type="string")
     */
    protected $country;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $postalCode;

    /**
     * @ORM\Column(type="float")
     */
    protected $lat;

    /**
     * @ORM\Column(type="float")
     */
    protected $lng;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $price;


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
     * @return Property
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
     * Set description
     *
     * @param string $description
     * @return Property
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Property
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set forRent
     *
     * @param boolean $forRent
     * @return Property
     */
    public function setForRent($forRent)
    {
        $this->forRent = $forRent;

        return $this;
    }

    /**
     * Get forRent
     *
     * @return boolean 
     */
    public function getForRent()
    {
        return $this->forRent;
    }

    /**
     * Set leaseTerm
     *
     * @param string $leaseTerm
     * @return Property
     */
    public function setLeaseTerm($leaseTerm)
    {
        $this->leaseTerm = $leaseTerm;

        return $this;
    }

    /**
     * Get leaseTerm
     *
     * @return string 
     */
    public function getLeaseTerm()
    {
        return $this->leaseTerm;
    }

    /**
     * Set bedrooms
     *
     * @param integer $bedrooms
     * @return Property
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    /**
     * Get bedrooms
     *
     * @return integer 
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * Set bathsFull
     *
     * @param integer $bathsFull
     * @return Property
     */
    public function setBathsFull($bathsFull)
    {
        $this->bathsFull = $bathsFull;

        return $this;
    }

    /**
     * Get bathsFull
     *
     * @return integer 
     */
    public function getBathsFull()
    {
        return $this->bathsFull;
    }

    /**
     * Set bathsHalf
     *
     * @param integer $bathsHalf
     * @return Property
     */
    public function setBathsHalf($bathsHalf)
    {
        $this->bathsHalf = $bathsHalf;

        return $this;
    }

    /**
     * Get bathsHalf
     *
     * @return integer 
     */
    public function getBathsHalf()
    {
        return $this->bathsHalf;
    }

    /**
     * Set laundry
     *
     * @param boolean $laundry
     * @return Property
     */
    public function setLaundry($laundry)
    {
        $this->laundry = $laundry;

        return $this;
    }

    /**
     * Get laundry
     *
     * @return boolean 
     */
    public function getLaundry()
    {
        return $this->laundry;
    }

    /**
     * Set view
     *
     * @param string $view
     * @return Property
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return string 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set lotSize
     *
     * @param string $lotSize
     * @return Property
     */
    public function setLotSize($lotSize)
    {
        $this->lotSize = $lotSize;

        return $this;
    }

    /**
     * Get lotSize
     *
     * @return string 
     */
    public function getLotSize()
    {
        return $this->lotSize;
    }

    /**
     * Set yearBuilt
     *
     * @param integer $yearBuilt
     * @return Property
     */
    public function setYearBuilt($yearBuilt)
    {
        $this->yearBuilt = $yearBuilt;

        return $this;
    }

    /**
     * Get yearBuilt
     *
     * @return integer 
     */
    public function getYearBuilt()
    {
        return $this->yearBuilt;
    }

    /**
     * Set accessibility
     *
     * @param string $accessibility
     * @return Property
     */
    public function setAccessibility($accessibility)
    {
        $this->accessibility = $accessibility;

        return $this;
    }

    /**
     * Get accessibility
     *
     * @return string 
     */
    public function getAccessibility()
    {
        return $this->accessibility;
    }

    /**
     * Set mlsId
     *
     * @param integer $mlsId
     * @return Property
     */
    public function setMlsId($mlsId)
    {
        $this->mlsId = $mlsId;

        return $this;
    }

    /**
     * Get mlsId
     *
     * @return integer 
     */
    public function getMlsId()
    {
        return $this->mlsId;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Property
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
     * Set unit
     *
     * @param string $unit
     * @return Property
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Property
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
     * Set state
     *
     * @param string $state
     * @return Property
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Property
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set postalCode
     *
     * @param integer $postalCode
     * @return Property
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return integer 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Property
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return Property
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return float 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Property
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
     * Set user_id
     *
     * @param \UserBundle\Entity\User $userId
     * @return Property
     */
    public function setUserId(\UserBundle\Entity\User $userId = null)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
