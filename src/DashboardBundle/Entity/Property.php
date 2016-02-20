<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use UserBundle\Entity\User;


/**
 * @ORM\Entity
 * @ORM\Table(name="properties")
 * @GRID\Source(columns="id,name")
 */
class Property
{

    public function __construct(User $user){
        $this->user = $user;
    }

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
     * @GRID\Column(field="name", type="text" , filterable=true, title="Name", size=50)
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
     * @ORM\Column(type="boolean", nullable=false)
     * @GRID\Column(field="for_rent", type="boolean", filterable=false, title="For Rent?", sortable=true)

     */
    protected $for_rent;

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
