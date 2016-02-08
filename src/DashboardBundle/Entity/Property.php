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

}