<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="flyers")
 * @GRID\Source(columns="id,name,email,map_active,sender_name")
 */
class Flyer
{

    public function __construct(User $user){
        $this->user = $user;
        $this->creation_date = new \DateTime();
        $this->modification_date = $this->creation_date;
        $this->map_active = true;
        $this->map_active = 0;
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
     * @ORM\ManyToOne(targetEntity="Template")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $template;

    /**
     * @ORM\ManyToOne(targetEntity="FlyerStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="name", type="text" , filterable=true, title="Name",size=25)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $html;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $creation_date;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $modification_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_sent_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $address;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     * @GRID\Column(field="map_active", type="boolean" , filterable=false, title="Map active",size=25, sortable=false)
     */
    private $map_active;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $map_zoom;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $map_marker;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="sender_name", type="textext" , filterable=true, title="Locale", size=25, class="grey-text")
     */
    private $sender_name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="email", type="text" , filterable=true, title="Email",size=25)
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $email_reply;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $total_sent;
}
