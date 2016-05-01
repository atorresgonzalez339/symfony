<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use DashboardBundle\Business\SendFlyerBusiness;
use DashboardBundle\Entity\Activity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SendFlyerController extends BaseController
{
  private $serviceName = 'dashboard.sendflyer.business';

  /**
   * @return SendFlyerBusiness
   */
  public function getBusiness()
  {
    return parent::findBusiness($this->serviceName);
  }

  /**
   * @Route("/send/{flyer_id}/preview", name="send_flyer_preview")
   */
  public function sendPreviewAction(Request $request, $flyer_id)
  {
    $mandrillBusiness = $this->findBusiness('dashboard.mandrill.business');
    $user = $this->getUser();
    $flyer = $this->getDoctrine()
                  ->getRepository('DashboardBundle:Flyer')
                  ->find($flyer_id);

    if(!$user->getProfile()->getMandrillSubaccount()){
      $mandrillBusiness->createSubAccount($user);
    }
    else{
      $subAccountInfo = $mandrillBusiness->getSubaccount($user->getProfile()->getMandrillSubaccount());
    }

    return $this->render('DashboardBundle:SendFlyer:preview.html.twig', array(
      'flyer' => $flyer,
    ));

  }

  /**
   * @Route("/send/{flyer_id}", name="send_flyer")
   */
  public function sendAction(Request $request, $flyer_id){

    $flyerBusiness = $this->findBusiness('dashboard.flyer.business');

    $flyer = $this->getDoctrine()
                  ->getRepository('DashboardBundle:Flyer')
                  ->find($flyer_id);

    $flyer = $flyerBusiness->replaceImages($flyer);

    //$contacts = array('llfrometa@gmail.com', 'atorresgonzalez339@gmail.com', 'julius12jp12@gmail.com');
    $contacts = array('atorresgonzalez339@gmail.com');

    $activity_id = uniqid("activity");

    $result = $this->getBusiness()->sendFlyer($flyer, $contacts, $activity_id);

    $flyer->setLastSentDate(new \DateTime());
    $flyer->addTotalSent();
    $flyerBusiness->saveFlyer($flyer);

    $activity = new Activity($flyer);
    $activity->setSentDate($flyer->getLastSentDate());
    $activity->setActivityId($activity_id);

    $flyerBusiness->saveData($activity);

    return $this->redirectToRoute('activity_index');

  }

}
