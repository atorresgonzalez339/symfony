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
   * @Route("/change_plan/{plan_id}", name="upgrade_change_plan")
   */
  public function changePlanAction(Request $request, $plan_id)
  {
    $user = $this->getUser();

    $plan = $this->getDoctrine()
      ->getRepository('DashboardBundle:Plan')
      ->find($plan_id);

    $this->getBusiness()->updatePlan($user, $plan);

    $this->addFlash('success', 'Your current plan was updated');

    return $this->redirectToRoute('upgrade_index');

  }

  /**
   * @Route("/checkout/{plan_id}", name="upgrade_checkout")
   */
  public function checkoutAction(Request $request, $plan_id)
  {
    $user = $this->getUser();

    $plan = $this->getDoctrine()
                 ->getRepository('DashboardBundle:Plan')
                 ->find($plan_id);

    $cardInfo = $this->getBusiness()->getCardInformation($user);

    return $this->render('DashboardBundle:Upgrade:checkout.html.twig', array(
      'plan' => $plan,
      'card_info' => $cardInfo
    ));
  }

  /**
   * @Route("/update_card", name="upgrade_update_card")
   */
  public function updateCardAction(Request $request){
    $user = $this->getUser();
    $token = $request->get('token');
    $result = $this->getBusiness()->updateCard($user, $token);
    return new JsonResponse(array('status' => 'ok'));
  }

}