<?php

namespace UserBundle\Business;

use CommonBundle\Business\BaseBusiness;
use CommonBundle\Controller\BaseController;
use UserBundle\Entity\UserProfile;

class ProfileBusiness extends BaseBusiness {

  public function __construct($em) {
    parent::__construct($em);
  }

  public function saveProfile(UserProfile $profile){
    $this->saveData($profile);
  }

}