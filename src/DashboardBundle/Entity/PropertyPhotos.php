<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="property_photos")
 */
class PropertyPhotos
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
    private $url;
}