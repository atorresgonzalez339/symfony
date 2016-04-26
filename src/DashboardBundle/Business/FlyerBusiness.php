<?php

namespace DashboardBundle\Business;
use CommonBundle\Business\BaseBusiness;
use DashboardBundle\Entity\Flyer;
use Doctrine\ORM\EntityManager;

class FlyerBusiness extends BaseBusiness {
	
    public function __construct(EntityManager $em) {
      parent::__construct($em);
    }

    public function saveFlyer(Flyer $flyer){
      $this->saveData($flyer);
    }
}