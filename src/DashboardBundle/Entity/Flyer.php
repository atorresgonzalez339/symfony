<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="flyers")
 * @GRID\Source(columns="id,name,email_reply,sender_name,map_active")
 */

class Flyer
{

    public function __construct(User $user, Property $property, Template $template){
        $this->user = $user;
        $this->creation_date = new \DateTime();
        $this->modification_date = $this->creation_date;
        $this->property = $property;
        $this->template = $template;
        $this->total_sent = 0;

        //Binding Flyer with Property
        $this->email       = $user->getProfile()->getEmail();
        $this->sender_name = $user->getProfile()->getFullName();
        $this->email_reply = $user->getProfile()->getEmail();
        $this->address = $property->getAddress();
        $this->map_active = true;
        $this->lat = $property->getLat();
        $this->lng = $property->getLng();
        $this->map_zoom = $property->getMapZoom();
        $this->map_center_lat = $property->getMapCenterLat();
        $this->map_center_lng = $property->getMapCenterLng();
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
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    private $property;

    /**
     * @ORM\ManyToOne(targetEntity="Template")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $template;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="name", type="text" , filterable=true, title="Name",size=25, operatorsVisible=false)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $html;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $html_edit;

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
     * @ORM\Column(type="boolean")
     * @GRID\Column(field="map_active", type="boolean" , filterable=false, title="Map active",size=25, sortable=false, operatorsVisible=false)
     */
    private $map_active;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $map_zoom;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="sender_name", type="textext" , filterable=false, title="Locale", size=25, class="grey-text", operatorsVisible=false)
     */
    private $sender_name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="email_reply", type="textext" , filterable=false, title="Locale", size=25, class="grey-text", operatorsVisible=false)
     */
    private $email_reply;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $total_sent;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $lng;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $map_center_lat;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $map_center_lng;

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
     * @return Flyer
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
     * Set html
     *
     * @param string $html
     * @return Flyer
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * @return string 
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set creation_date
     *
     * @param \DateTime $creationDate
     * @return Flyer
     */
    public function setCreationDate($creationDate)
    {
        $this->creation_date = $creationDate;

        return $this;
    }

    /**
     * Get creation_date
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set modification_date
     *
     * @param \DateTime $modificationDate
     * @return Flyer
     */
    public function setModificationDate($modificationDate)
    {
        $this->modification_date = $modificationDate;

        return $this;
    }

    /**
     * Get modification_date
     *
     * @return \DateTime 
     */
    public function getModificationDate()
    {
        return $this->modification_date;
    }

    /**
     * Set last_sent_date
     *
     * @param \DateTime $lastSentDate
     * @return Flyer
     */
    public function setLastSentDate($lastSentDate)
    {
        $this->last_sent_date = $lastSentDate;

        return $this;
    }

    /**
     * Get last_sent_date
     *
     * @return \DateTime 
     */
    public function getLastSentDate()
    {
        return $this->last_sent_date;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Flyer
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Flyer
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
     * Set map_active
     *
     * @param boolean $mapActive
     * @return Flyer
     */
    public function setMapActive($mapActive)
    {
        $this->map_active = $mapActive;

        return $this;
    }

    /**
     * Get map_active
     *
     * @return boolean 
     */
    public function getMapActive()
    {
        return $this->map_active;
    }

    /**
     * Set map_zoom
     *
     * @param integer $mapZoom
     * @return Flyer
     */
    public function setMapZoom($mapZoom)
    {
        $this->map_zoom = $mapZoom;

        return $this;
    }

    /**
     * Get map_zoom
     *
     * @return integer 
     */
    public function getMapZoom()
    {
        return $this->map_zoom;
    }

    /**
     * Set sender_name
     *
     * @param string $senderName
     * @return Flyer
     */
    public function setSenderName($senderName)
    {
        $this->sender_name = $senderName;

        return $this;
    }

    /**
     * Get sender_name
     *
     * @return string 
     */
    public function getSenderName()
    {
        return $this->sender_name;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Flyer
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set email_reply
     *
     * @param string $emailReply
     * @return Flyer
     */
    public function setEmailReply($emailReply)
    {
        $this->email_reply = $emailReply;

        return $this;
    }

    /**
     * Get email_reply
     *
     * @return string 
     */
    public function getEmailReply()
    {
        return $this->email_reply;
    }

    /**
     * Set total_sent
     *
     * @param integer $totalSent
     * @return Flyer
     */
    public function setTotalSent($totalSent)
    {
        $this->total_sent = $totalSent;

        return $this;
    }

    public function addTotalSent()
    {
        $this->total_sent = $this->total_sent++;

        return $this;
    }

    /**
     * Get total_sent
     *
     * @return integer 
     */
    public function getTotalSent()
    {
        return $this->total_sent;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return Flyer
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
     * Set property
     *
     * @param \DashboardBundle\Entity\Property $property
     * @return Flyer
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

    /**
     * Set template
     *
     * @param \DashboardBundle\Entity\Template $template
     * @return Flyer
     */
    public function setTemplate(\DashboardBundle\Entity\Template $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \DashboardBundle\Entity\Template 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Flyer
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
     * @return Flyer
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
     * Set html_edit
     *
     * @param string $htmlEdit
     * @return Flyer
     */
    public function setHtmlEdit($htmlEdit)
    {
        $this->html_edit = $htmlEdit;

        return $this;
    }

    /**
     * Get html_edit
     *
     * @return string 
     */
    public function getHtmlEdit()
    {
        return $this->html_edit;
    }

    /**
     * Set map_center_lat
     *
     * @param string $mapCenterLat
     * @return Flyer
     */
    public function setMapCenterLat($mapCenterLat)
    {
        $this->map_center_lat = $mapCenterLat;

        return $this;
    }

    /**
     * Get map_center_lat
     *
     * @return string 
     */
    public function getMapCenterLat()
    {
        return $this->map_center_lat;
    }

    /**
     * Set map_center_lng
     *
     * @param string $mapCenterLng
     * @return Flyer
     */
    public function setMapCenterLng($mapCenterLng)
    {
        $this->map_center_lng = $mapCenterLng;

        return $this;
    }

    /**
     * Get map_center_lng
     *
     * @return string 
     */
    public function getMapCenterLng()
    {
        return $this->map_center_lng;
    }
}
