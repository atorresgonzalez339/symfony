<?php

namespace DashboardBundle\Business;

use CommonBundle\Business\BaseBusiness;
use DashboardBundle\Entity\Plan;
use DashboardBundle\Entity\UserPlan;
use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;

class UpgradeBusiness extends BaseBusiness{

    public function __construct(EntityManager $em) {
      parent::__construct($em);
    }

    public function addUserPlan(User $user, Plan $plan){
      $userPlan = new UserPlan($user, $plan);
      $this->saveData($userPlan);
    }


}