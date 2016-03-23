<?php

namespace DashboardBundle\Business;
use CommonBundle\Business\BaseBusiness;
use Doctrine\ORM\EntityManager;

class ContactBusiness extends BaseBusiness {
	
    public function __construct(EntityManager $em) {
      parent::__construct($em);
    }
}