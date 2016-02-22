<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\UserProfile;
use UserBundle\Form\ProfileType;
use CommonBundle\Controller\BaseController;

class ProfileController extends BaseController
{
    private $serviceName = 'user.profile.business';

    public function getBusiness() {
      return parent::findBusiness($this->serviceName);
    }

    /**
     * @Route("/profile", name="profile_index")
     */
    public function indexAction(Request $request){

      $user = $this->getUser();

      $profile = $this->getDoctrine()
              ->getRepository('UserBundle:UserProfile')
              ->findByUser($user->getId());

      if(!$profile){
      	$profile = new UserProfile($user);
      }

      $profile_form = $this->createForm(ProfileType::class, $profile);

      return $this->render('UserBundle:Profile:index.html.twig', array(
        'profile_form' => $profile_form->createView()
      ));
    }

    /**
     * @Route("/profile/update", name="profile_save")
     */
    public function saveAction(Request $request){
      return $this->redirect($this->generateUrl('profile_index'));
    }
}
