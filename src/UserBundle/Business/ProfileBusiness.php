<?php

namespace UserBundle\Business;

use CommonBundle\Business\BaseBusiness;
use CommonBundle\Controller\BaseController;
use UserBundle\Entity\User;
use UserBundle\Entity\UserProfile;

class ProfileBusiness extends BaseBusiness {

  protected $container;

  public function __construct($em, $container) {
    parent::__construct($em);
    $this->container = $container;
  }

  public function saveProfile(UserProfile $profile){
    $this->saveData($profile);
  }

  public function saveAccount(User $user){
    $userManager = $this->container->get('fos_user.user_manager');
    $userManager->updateUser($user);
  }
}