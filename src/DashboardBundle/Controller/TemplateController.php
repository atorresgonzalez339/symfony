<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TemplateController extends Controller{

	/**
 	 * @Route("/templates", name="template_index")
 	 */
  public function indexAction(Request $request){

  	$templates = array(0, 1, 2);
  	$id_property = $request->get('id_property');

		return $this->render('DashboardBundle:Templates:index.html.twig', array(
       'templates' => $templates,
       'id_property' => $id_property
   	));
  }

}