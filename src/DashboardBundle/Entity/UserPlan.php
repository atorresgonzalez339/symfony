<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_plans")
 */
class UserPlan
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
     * @ORM\ManyToOne(targetEntity="Plan", inversedBy="plans")
     * @ORM\JoinColumn(name="plan_id", referencedColumnName="id")
     */
    private $plan;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $total_flyers;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $total_emails;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $date_end;

    /**
     * UserPlan constructor.
     */
    public function __construct(User $user, Plan $plan)
    {
        $this->user = $user;
        $this->plan = $plan;
        $this->total_flyers = 0;
        $this->total_emails = 0;
        $this->date_start = new \DateTime();
        $this->date_end = new \DateTime();
        $this->date_end->add(new \DateInterval('P1M'));
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
     * Set total_flyers
     *
     * @param integer $totalFlyers
     * @return UserPlan
     */
    public function setTotalFlyers($totalFlyers)
    {
        $this->total_flyers = $totalFlyers;

        return $this;
    }

    /**
     * Get total_flyers
     *
     * @return integer 
     */
    public function getTotalFlyers()
    {
        return $this->total_flyers;
    }

    /**
     * Set total_emails
     *
     * @param integer $totalEmails
     * @return UserPlan
     */
    public function setTotalEmails($totalEmails)
    {
        $this->total_emails = $totalEmails;

        return $this;
    }

    /**
     * Get total_emails
     *
     * @return integer 
     */
    public function getTotalEmails()
    {
        return $this->total_emails;
    }

    /**
     * Set date_start
     *
     * @param \DateTime $dateStart
     * @return UserPlan
     */
    public function setDateStart($dateStart)
    {
        $this->date_start = $dateStart;

        return $this;
    }

    /**
     * Get date_start
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * Set date_end
     *
     * @param \DateTime $dateEnd
     * @return UserPlan
     */
    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;

        return $this;
    }

    /**
     * Get date_end
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return UserPlan
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
     * Set plan
     *
     * @param \DashboardBundle\Entity\Plan $plan
     * @return UserPlan
     */
    public function setPlan(\DashboardBundle\Entity\Plan $plan = null)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return \DashboardBundle\Entity\Plan 
     */
    public function getPlan()
    {
        return $this->plan;
    }
}
