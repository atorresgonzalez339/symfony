<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class ContactController extends Controller{

	/**
 	 * @Route("/contacts", name="contact_index")
 	 */
  public function indexAction(Request $request){

    return $this->render('DashboardBundle:Contact:index.html.twig');

  }

}