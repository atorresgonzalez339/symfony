<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class UpgradeController extends Controller
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

}