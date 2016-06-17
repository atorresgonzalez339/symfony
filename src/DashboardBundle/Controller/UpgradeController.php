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

    $totalAmount =

    $plan = $this->getDoctrine()
      ->getRepository('DashboardBundle:Plan')
      ->find($plan_id);

    $this->getBusiness()->updatePlan($user, $plan);

    $this->addFlash('success', 'Your current plan was updated');

    return $this->redirectToRoute('upgrade_index');

  }

  /**
   * @Route("/add_next_plan", name="upgrade_add_next_plan")
   */
  public function addNextPlanAction(Request $request)
  {
    $user = $this->getUser();
    $next_plan_id = $request->get('next_plan_id');

    $currentPlan = $user->getCurrentPlan();

    if(!$next_plan_id || $next_plan_id == $currentPlan->getPlan()->getId() ) {
      return $this->redirectToRoute('upgrade_index');
    }
    else if($next_plan_id == '-1'){
      $nextPlan = null;
      $message = 'Next plan canceled';
    }
    else{
      $nextPlan = $this->getDoctrine()
        ->getRepository('DashboardBundle:Plan')
        ->find($next_plan_id);
      $message = 'Next plan set up';
    }


    $this->getBusiness()->addNextPlan($currentPlan, $nextPlan);

    $this->addFlash('success', $message);

    return $this->redirectToRoute('upgrade_index');

  }

  /**
   * @Route("/checkout/{plan_id}", name="upgrade_checkout")
   */
  public function checkoutAction(Request $request, $plan_id = null)
  {
    $user = $this->getUser();

    $plan_id = $plan_id ? $plan_id : $request->get('plan_id');

    $plan = $this->getDoctrine()
                 ->getRepository('DashboardBundle:Plan')
                 ->find($plan_id);

    $cardInfo = $this->getBusiness()->getCardInformation($user);

    $total_amount = $this->getBusiness()->getTotalAmount($plan);

    return $this->render('DashboardBundle:Upgrade:checkout.html.twig', array(
      'plan' => $plan,
      'card_info' => $cardInfo,
      'total_amount' => $total_amount
    ));
  }

  /**
   * @Route("/update_card", name="upgrade_update_card")
   */
  public function updateCardAction(Request $request){
    $user = $this->getUser();
    $token = $request->get('token');
    $result = $this->getBusiness()->updateCard($user, $token);
    return new JsonResponse(array('status' => 'ok', 'data' => $result));
  }

}