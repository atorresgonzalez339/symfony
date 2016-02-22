<?php

namespace DashboardBundle\Business;
use CommonBundle\Business\BaseBusiness;

class FlyerBusiness extends BaseBusiness {
	
    public function __construct(EntityManager $em) {
      parent::__construct($em);
    }

}