<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use DashboardBundle\Business\SendFlyerBusiness;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ActivityController extends BaseController
{
  private $serviceName = 'dashboard.reportflyer.business';

  /**
   * @return SendFlyerBusiness
   */
  public function getBusiness()
  {
    return parent::findBusiness($this->serviceName);
  }

  /**
   * @Route("/activity", name="activity_index")
   */
  public function indexAction(Request $request)
  {

    $mandrillBusiness = $this->get('dashboard.mandrill.business');

    $user = $this->getUser();
    $mandrillSubaccount =  $user->getProfile()->getMandrillSubaccount();
    if($mandrillSubaccount){
      $subaccount = $mandrillBusiness->getSubAccount($mandrillSubaccount);
//      echo "<pre>";
//      print_r($subaccount);
//      die();
      $activities = $this->getDoctrine()
                         ->getRepository('DashboardBundle:Activity')
                         ->findBy(array('user' => $user->getId()));

      return $this->render('DashboardBundle:Activity:index.html.twig', array(
        'subaccount' => $subaccount,
        'activities' => $activities
      ));

    }
    else{
      return $this->render('DashboardBundle:Activity:index.html.twig');
    }
  }

  /**
   * @Route("/activity/{id}/detail", name="activity_detail")
   */
  public function detailAction(Request $request)
  {
    die('aki');
  }

}
