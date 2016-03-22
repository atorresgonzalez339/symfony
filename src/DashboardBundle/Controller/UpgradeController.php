<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class UpgradeController extends Controller{

	/**
 	 * @Route("/upgrade", name="upgrade_index")
 	 */
  public function indexAction(Request $request){

    return $this->render('DashboardBundle:Upgrade:index.html.twig');

  }

}