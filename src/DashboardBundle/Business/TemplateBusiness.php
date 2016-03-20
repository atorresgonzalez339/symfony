<?php

namespace DashboardBundle\Business;

use CommonBundle\Business\BaseBusiness;

class TemplateBusiness extends BaseBusiness{

    public function __construct(EntityManager $em) {
      parent::__construct($em);
    }

}