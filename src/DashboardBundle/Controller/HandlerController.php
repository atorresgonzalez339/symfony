<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class HandlerController extends BaseController{

	/**
 	 * @Route("/stripe", name="handler_stripe")
 	 */
  public function indexAction(Request $request){

			$upgradeBusiness = $this->findBusiness('dashboard.upgrade.business');

			$event = json_decode($request->getContent(), true);

			$stripeEvent = \Stripe_Event::retrieve($event['id']);

			if($stripeEvent && isset($stripeEvent->type)){
				switch($stripeEvent->type){
					case 'invoice.payment_succeeded':
						$upgradeBusiness->renewPlan($stripeEvent);
					break;
				}
			}

			return new Response('Successfully');
  }

}