<?php
namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserProfile", mappedBy="user")
     */
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity="\DashboardBundle\Entity\UserPlan", mappedBy="user")
     */
    private $plans;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }



    /**
     * Add plans
     *
     * @param \DashboardBundle\Entity\UserPlan $plans
     * @return User
     */
    public function addPlan(\DashboardBundle\Entity\UserPlan $plans)
    {
        $this->plans[] = $plans;

        return $this;
    }

    /**
     * Remove plans
     *
     * @param \DashboardBundle\Entity\UserPlan $plans
     */
    public function removePlan(\DashboardBundle\Entity\UserPlan $plans)
    {
        $this->plans->removeElement($plans);
    }

    /**
     * Get plans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlans()
    {
        return $this->plans;
    }

    public function getCurrentPlan(){
        return $this->getPlans()->last();
    }

}
