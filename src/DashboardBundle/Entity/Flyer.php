<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="flyers")
 */
class Flyer
{

    public function __construct(){
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
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="Template")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $template_id;

    /**
     * @ORM\ManyToOne(targetEntity="FlyerStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status_id;

    /**
     * @ORM\Column(type="string", nullable=false)
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
     */
    private $sender_name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", nullable=false)
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
     * Set map_marker
     *
     * @param float $mapMarker
     * @return Flyer
     */
    public function setMapMarker($mapMarker)
    {
        $this->map_marker = $mapMarker;

        return $this;
    }

    /**
     * Get map_marker
     *
     * @return float 
     */
    public function getMapMarker()
    {
        return $this->map_marker;
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
     * Set email
     *
     * @param string $email
     * @return Flyer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set user_id
     *
     * @param \UserBundle\Entity\User $userId
     * @return Flyer
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

    /**
     * Set template_id
     *
     * @param \DashboardBundle\Entity\Template $templateId
     * @return Flyer
     */
    public function setTemplateId(\DashboardBundle\Entity\Template $templateId = null)
    {
        $this->template_id = $templateId;

        return $this;
    }

    /**
     * Get template_id
     *
     * @return \DashboardBundle\Entity\Template 
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * Set status_id
     *
     * @param \DashboardBundle\Entity\FlyerStatus $statusId
     * @return Flyer
     */
    public function setStatusId(\DashboardBundle\Entity\FlyerStatus $statusId = null)
    {
        $this->status_id = $statusId;

        return $this;
    }

    /**
     * Get status_id
     *
     * @return \DashboardBundle\Entity\FlyerStatus 
     */
    public function getStatusId()
    {
        return $this->status_id;
    }
}
