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

    $property_id = $request->get('property_id');
    $property_type = $request->get('property_type');

  	$templates = $this->getDoctrine()
        			->getRepository('DashboardBundle:Template')
        			->findAll();

		return $this->render('DashboardBundle:Templates:index.html.twig', array(
       'templates' => $templates,
       'property_id' => $property_id,
       'property_type' => $property_type
   	));
  }

}