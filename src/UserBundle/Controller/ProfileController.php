<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
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

      $profile = $this->getBusiness()
                      ->getRepository('User', 'UserProfile')
                      ->findByUserId($user->getId());

      if(!$profile){
      	$profile = new UserProfile($user);
      }

      $profile_form = $this->createForm(ProfileType::class, $profile);

      return $this->render('UserBundle:Profile:index.html.twig', array(
        'profile' => $profile,
        'profile_form' => $profile_form->createView()
      ));
    }

    /**
     * @Route("/profile/save", name="profile_save")
     */
    public function saveAction(Request $request){
      $user = $this->getUser();

      $profile = $this->getBusiness()
                      ->getRepository('User', 'UserProfile')
                      ->findByUserId($user->getId());

      if(!$profile){
        $profile = new UserProfile($user);
      }

      $profile_form = $this->createForm(ProfileType::class, $profile);

      $profile_form->handleRequest($request);

      if ($profile_form->isValid()) {
        $this->getBusiness()->saveProfile($profile);
        $this->addFlash('success', 'Profile saved');
        return $this->redirect($this->generateUrl('profile_index'));
      }


      $this->addFlash('error', 'Invalid data');
      return $this->redirect($this->generateUrl('profile_index'));
    }

}
