<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpgradeController extends BaseController
{

  private $serviceName = 'dashboard.upgrade.business';

  public function getBusiness()
  {
    return parent::findBusiness($this->serviceName);
  }

  /**
   * @Route("/upgrade", name="upgrade_index")
   */
  public function indexAction(Request $request)
  {
    $user = $this->getUser();

    $plans = $this->getDoctrine()
      ->getRepository('DashboardBundle:Plan')
      ->findAll();

    $currentPlan = $user->getCurrentPlan();

    return $this->render('DashboardBundle:Upgrade:index.html.twig', array(
      'plans' => $plans,
      'current_plan' => $currentPlan
    ));
  }

  /**
   * @Route("/update_card", name="upgrade_update_card")
   */
  public function updateCardAction(Request $request){
    $user = $this->getUser();
    $token = $request->get('token');
    $result = $this->getBusiness()->updateCard($user, $token);
    return new JsonResponse($result);
  }

}