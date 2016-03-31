<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\UserProfile;
use UserBundle\Form\AccountType;
use UserBundle\Form\ProfileType;
use CommonBundle\Controller\BaseController;
use UserBundle\Form\PictureType;

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

      $upgradeBusiness = $this->findBusiness('dashboard.upgrade.business');

      $profile = $this->getBusiness()
                      ->getRepository('User', 'UserProfile')
                      ->findByUserId($user->getId());

      $cardInfo = $upgradeBusiness->getCardInformation($user);

      $invoices = $upgradeBusiness->getInvoices($user);

      if(!$profile){
      	$profile = new UserProfile($user);
      }

      $profile_form = $this->createForm(ProfileType::class, $profile);
      $account_form = $this->createForm(AccountType::class, $user);
      $picture_form = $this->createForm(PictureType::class, $profile);

      return $this->render('UserBundle:Profile:index.html.twig', array(
        'profile' => $profile,
        'profile_form' => $profile_form->createView(),
        'account_form' => $account_form->createView(),
        'picture_form' => $picture_form->createView(),
        'card_info' => $cardInfo,
        'invoices' => $invoices
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

        //Add free Plan to the user after complete profile
        if(!$user->getCurrentPlan()){
          $freePlan =  $this->getBusiness()
                            ->getRepository('Dashboard', 'Plan')
                            ->find(1);
          $upgradeBusiness = $this->findBusiness('dashboard.upgrade.business');
          $upgradeBusiness->updatePlan($user, $freePlan);
        }

        $this->addFlash('success', 'Profile saved');
        return $this->redirect($this->generateUrl('profile_index'));
      }


      $this->addFlash('error', 'Invalid data');
      return $this->redirect($this->generateUrl('profile_index'));
    }

  /**
   * @Route("/profile/save_account", name="profile_save_account")
   */
  public function saveAccountAction(Request $request){
    $user = $this->getUser();

    $account_form = $this->createForm(AccountType::class, $user);

    $account_form->handleRequest($request);


    if ($account_form->isValid()) {

      $rpassword = $request->get('rpassword');

      if($rpassword != $user->getPlainPassword()){
        $this->addFlash('error', 'Passwords does not match');
      }
      else{
        $this->getBusiness()->saveAccount($user);
        $this->addFlash('success', 'Account updated');
      }
    }
    else{
      $this->addFlash('error', 'Invalid data');
    }

    return $this->redirect($this->generateUrl('profile_index'));
  }

  /**
   * @Route("/profile/upload_picture", name="profile_upload_picture")
   */
  public function uploadPictureAction(Request $request){
    $user = $this->getUser();

    $profile = $this->getBusiness()
                    ->getRepository('User', 'UserProfile')
                    ->findByUserId($user->getId());

    $picture_form = $this->createForm(PictureType::class, $profile);

    $picture_form->handleRequest($request);

    if ($picture_form->isValid()) {
        $this->getBusiness()->saveProfile($profile);
        return new JsonResponse(array(
          'status' => 'ok'
        ));
    }
    else{
      return new JsonResponse(array(
        'status' => 'error'
      ));
    }
  }

}
