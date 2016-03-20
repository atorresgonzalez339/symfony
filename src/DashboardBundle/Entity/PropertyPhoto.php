<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="property_photos")
 */
class PropertyPhoto
{


	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumn(name="propery_id", referencedColumnName="id")
     */
    private $property;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo_url;

    /**
     * PropertyPhoto constructor.
     * @param $property
     */
    public function __construct(Property $property)
    {
        $this->property = $property;
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
     * @return mixed
     */
    public function getPhotoId()
    {
        return $this->photo_id;
    }

    /**
     * @param mixed $photo_id
     */
    public function setPhotoId($photo_id)
    {
        $this->photo_id = $photo_id;
    }

    /**
     * @return mixed
     */
    public function getPhotoUrl()
    {
        return $this->photo_url;
    }

    /**
     * @param mixed $photo_url
     */
    public function setPhotoUrl($photo_url)
    {
        $this->photo_url = $photo_url;
    }



    /**
     * Set property
     *
     * @param \DashboardBundle\Entity\Property $property
     * @return PropertyPhotos
     */
    public function setProperty(\DashboardBundle\Entity\Property $property = null)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return \DashboardBundle\Entity\Property 
     */
    public function getProperty()
    {
        return $this->property;
    }
}
