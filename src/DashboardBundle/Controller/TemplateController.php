<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class TemplateController extends Controller{

	/**
 	 * @Route("/templates", name="template_index")
 	 */
  public function indexAction(Request $request){

		$source = new Entity('DashboardBundle:Template');
		$grid = $this->get('grid');
		$grid->setSource($source);
		$grid->hideColumns(array('id'));
		$grid->addMassAction(new DeleteMassAction());
		$grid->setLimits($this->container->getParameter('admin.paginator.limits.config'));

		if ($request->isXmlHttpRequest()) {
			return $grid->getGridResponse('DashboardBundle:Templates:indexAjax.html.twig');
		}
		if ($grid->isReadyForRedirect() ) {
			return new RedirectResponse($grid->getRouteUrl());
		}

		return $grid->getGridResponse('DashboardBundle:Templates:index.html.twig');

//    $property_id = $request->get('property_id');
//
//  	$templates = $this->getDoctrine()
//        			->getRepository('DashboardBundle:Template')
//        			->findAll();
//
//		return $this->render('DashboardBundle:Templates:index.html.twig', array(
//       'templates' => $templates,
//       'property_id' => $property_id,
//   	));
  }

}