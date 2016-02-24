<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use UserBundle\Entity\User;
use DashboardBundle\DBAL\Types\PropertyEnumType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="properties")
 * @GRID\Source(columns="id,name")
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
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="name", type="text" , filterable=true, title="Name", size=50)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $amenities;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $features;

    /**
     * @ORM\Column(type="PropertyEnumType", nullable=true)
     * @DoctrineAssert\Enum(entity="DashboardBundle\DBAL\Types\PropertyEnumType")
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @GRID\Column(field="for_rent", type="boolean", filterable=false, title="For Rent?", sortable=true)

     */
    protected $for_rent;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lease_term;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $bedrooms;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $bathrooms;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $parking_spaces;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $unit_size;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $year_built;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $mls_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $unit;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $postal_code;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $lng;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $list_price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $close_price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $rent_price;

    protected $temp_photos;


    public function __construct(User $user){
        $this->user = $user;
        $this->temp_photos = new ArrayCollection();
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
     * Set amenities
     *
     * @param string $amenities
     * @return Property
     */
    public function setAmenities($amenities)
    {
        $this->amenities = $amenities;

        return $this;
    }

    /**
     * Get amenities
     *
     * @return string 
     */
    public function getAmenities()
    {
        return $this->amenities;
    }

    /**
     * Set features
     *
     * @param string $features
     * @return Property
     */
    public function setFeatures($features)
    {
        $this->features = $features;

        return $this;
    }

    /**
     * Get features
     *
     * @return string 
     */
    public function getFeatures()
    {
        return $this->features;
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
     * Set for_rent
     *
     * @param boolean $forRent
     * @return Property
     */
    public function setForRent($forRent)
    {
        $this->for_rent = $forRent;

        return $this;
    }

    /**
     * Get for_rent
     *
     * @return boolean 
     */
    public function getForRent()
    {
        return $this->for_rent;
    }

    /**
     * Set lease_term
     *
     * @param string $leaseTerm
     * @return Property
     */
    public function setLeaseTerm($leaseTerm)
    {
        $this->lease_term = $leaseTerm;

        return $this;
    }

    /**
     * Get lease_term
     *
     * @return string 
     */
    public function getLeaseTerm()
    {
        return $this->lease_term;
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
     * Set bathrooms
     *
     * @param integer $bathrooms
     * @return Property
     */
    public function setBathrooms($bathrooms)
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    /**
     * Get bathrooms
     *
     * @return integer 
     */
    public function getBathrooms()
    {
        return $this->bathrooms;
    }

    /**
     * Set parking_spaces
     *
     * @param string $parkingSpaces
     * @return Property
     */
    public function setParkingSpaces($parkingSpaces)
    {
        $this->parking_spaces = $parkingSpaces;

        return $this;
    }

    /**
     * Get parking_spaces
     *
     * @return string 
     */
    public function getParkingSpaces()
    {
        return $this->parking_spaces;
    }

    /**
     * Set unit_size
     *
     * @param string $unitSize
     * @return Property
     */
    public function setUnitSize($unitSize)
    {
        $this->unit_size = $unitSize;

        return $this;
    }

    /**
     * Get unit_size
     *
     * @return string 
     */
    public function getUnitSize()
    {
        return $this->unit_size;
    }

    /**
     * Set year_built
     *
     * @param integer $yearBuilt
     * @return Property
     */
    public function setYearBuilt($yearBuilt)
    {
        $this->year_built = $yearBuilt;

        return $this;
    }

    /**
     * Get year_built
     *
     * @return integer 
     */
    public function getYearBuilt()
    {
        return $this->year_built;
    }

    /**
     * Set mls_id
     *
     * @param integer $mlsId
     * @return Property
     */
    public function setMlsId($mlsId)
    {
        $this->mls_id = $mlsId;

        return $this;
    }

    /**
     * Get mls_id
     *
     * @return integer 
     */
    public function getMlsId()
    {
        return $this->mls_id;
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
     * Set postal_code
     *
     * @param integer $postalCode
     * @return Property
     */
    public function setPostalCode($postalCode)
    {
        $this->postal_code = $postalCode;

        return $this;
    }

    /**
     * Get postal_code
     *
     * @return integer 
     */
    public function getPostalCode()
    {
        return $this->postal_code;
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
     * Set list_price
     *
     * @param integer $listPrice
     * @return Property
     */
    public function setListPrice($listPrice)
    {
        $this->list_price = $listPrice;

        return $this;
    }

    /**
     * Get list_price
     *
     * @return integer 
     */
    public function getListPrice()
    {
        return $this->list_price;
    }

    /**
     * Set close_price
     *
     * @param integer $closePrice
     * @return Property
     */
    public function setClosePrice($closePrice)
    {
        $this->close_price = $closePrice;

        return $this;
    }

    /**
     * Get close_price
     *
     * @return integer 
     */
    public function getClosePrice()
    {
        return $this->close_price;
    }

    /**
     * Set rent_price
     *
     * @param integer $rentPrice
     * @return Property
     */
    public function setRentPrice($rentPrice)
    {
        $this->rent_price = $rentPrice;

        return $this;
    }

    /**
     * Get rent_price
     *
     * @return integer 
     */
    public function getRentPrice()
    {
        return $this->rent_price;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return Property
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return ArrayCollection
     */
    public function getTempPhotos()
    {
        return $this->temp_photos;
    }

    /**
     * @param ArrayCollection $temp_photos
     */
    public function setTempPhotos($temp_photos)
    {
        $this->temp_photos = $temp_photos;
    }


}
