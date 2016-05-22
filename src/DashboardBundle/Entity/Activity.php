<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="activity")
 */
class Activity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Flyer")
     * @ORM\JoinColumn(name="flyer_id", referencedColumnName="id")
     */
    private $flyer;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $activity_id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $sent_date;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $delivered;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $soft_bounced;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $hard_bounced;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $spam;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $unsubscribed;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $opens;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $unique_opens;

    /**
     * Activity constructor.
     * @param $flyer
     */
    public function __construct(Flyer $flyer)
    {
        $this->flyer = $flyer;
    }

    /**
     * Set activity_id
     *
     * @param string $activityId
     * @return Activity
     */
    public function setActivityId($activityId)
    {
        $this->activity_id = $activityId;

        return $this;
    }

    /**
     * Get activity_id
     *
     * @return string 
     */
    public function getActivityId()
    {
        return $this->activity_id;
    }

    /**
     * Set sent_date
     *
     * @param \DateTime $sentDate
     * @return Activity
     */
    public function setSentDate($sentDate)
    {
        $this->sent_date = $sentDate;

        return $this;
    }

    /**
     * Get sent_date
     *
     * @return \DateTime 
     */
    public function getSentDate()
    {
        return $this->sent_date;
    }

    /**
     * Set flyer
     *
     * @param \DashboardBundle\Entity\Flyer $flyer
     * @return Activity
     */
    public function setFlyer(\DashboardBundle\Entity\Flyer $flyer)
    {
        $this->flyer = $flyer;

        return $this;
    }

    /**
     * Get flyer
     *
     * @return \DashboardBundle\Entity\Flyer 
     */
    public function getFlyer()
    {
        return $this->flyer;
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return Activity
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
     * Set delivered
     *
     * @param integer $delivered
     * @return Activity
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;

        return $this;
    }

    public function addDelivered()
    {
        $this->delivered++;

        return $this;
    }

    /**
     * Get delivered
     *
     * @return integer 
     */
    public function getDelivered()
    {
        return $this->delivered;
    }

    /**
     * Set bounced
     *
     * @param integer $bounced
     * @return Activity
     */
    public function setBounced($bounced)
    {
        $this->bounced = $bounced;

        return $this;
    }

    /**
     * Get bounced
     *
     * @return integer 
     */
    public function getBounced()
    {
        return $this->bounced;
    }

    /**
     * Set opens
     *
     * @param integer $opens
     * @return Activity
     */
    public function setOpens($opens)
    {
        $this->opens = $opens;

        return $this;
    }

    public function addOpens()
    {
        $this->opens++;

        return $this;
    }

    /**
     * Get opens
     *
     * @return integer 
     */
    public function getOpens()
    {
        return $this->opens;
    }

    /**
     * Set unique_opens
     *
     * @param integer $uniqueOpens
     * @return Activity
     */
    public function setUniqueOpens($uniqueOpens)
    {
        $this->unique_opens = $uniqueOpens;

        return $this;
    }

    public function addUniqueOpens()
    {
        $this->unique_opens++;

        return $this;
    }

    /**
     * Get unique_opens
     *
     * @return integer 
     */
    public function getUniqueOpens()
    {
        return $this->unique_opens;
    }

    /**
     * Set soft_bounced
     *
     * @param integer $softBounced
     * @return Activity
     */
    public function setSoftBounced($softBounced)
    {
        $this->soft_bounced = $softBounced;

        return $this;
    }

    public function addSoftBounced()
    {
        $this->soft_bounced++;

        return $this;
    }

    /**
     * Get soft_bounced
     *
     * @return integer 
     */
    public function getSoftBounced()
    {
        return $this->soft_bounced;
    }

    /**
     * Set hard_bounced
     *
     * @param integer $hardBounced
     * @return Activity
     */
    public function setHardBounced($hardBounced)
    {
        $this->hard_bounced = $hardBounced;

        return $this;
    }

    public function addHardBounced()
    {
        $this->hard_bounced++;

        return $this;
    }

    /**
     * Get hard_bounced
     *
     * @return integer 
     */
    public function getHardBounced()
    {
        return $this->hard_bounced;
    }

    /**
     * Set spam
     *
     * @param integer $spam
     * @return Activity
     */
    public function setSpam($spam)
    {
        $this->spam = $spam;

        return $this;
    }

    public function addSpam()
    {
        $this->spam++;

        return $this;
    }

    /**
     * Get spam
     *
     * @return integer 
     */
    public function getSpam()
    {
        return $this->spam;
    }

    /**
     * Set unsubscribed
     *
     * @param integer $unsubscribed
     * @return Activity
     */
    public function setUnsubscribed($unsubscribed)
    {
        $this->unsubscribed = $unsubscribed;

        return $this;
    }

    public function addUnsubscribed()
    {
        $this->unsubscribed++;

        return $this;
    }

    /**
     * Get unsubscribed
     *
     * @return integer 
     */
    public function getUnsubscribed()
    {
        return $this->unsubscribed;
    }
}
