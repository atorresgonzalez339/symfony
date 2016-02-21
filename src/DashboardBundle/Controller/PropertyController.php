<?php

namespace DashboardBundle\Controller;

use DashboardBundle\Form\PropertyType;
use DashboardBundle\Entity\Property;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

class PropertyController extends BaseController
{

		private $serviceName = 'dashboard.property.business';

		public function getBusiness() {
			return parent::findBusiness($this->serviceName);
		}

		/**
		 * @Route("/properties", name="properties_index")
		 */
		public function indexAction(Request $request){$source = new Entity('DashboardBundle:Property');
			$grid = $this->get('grid');
			$grid->setSource($source);
			$grid->hideColumns(array('id'));
			$grid->addMassAction(new DeleteMassAction());
			$grid->setLimits($this->container->getParameter('admin.paginator.limits.config'));

			if ($request->isXmlHttpRequest()) {
				return $grid->getGridResponse('DashboardBundle:Propery:indexAjax.html.twig');
			}
			if ($grid->isReadyForRedirect() ) {
				return new RedirectResponse($grid->getRouteUrl());
			}

			return $grid->getGridResponse('DashboardBundle:Properties:index.html.twig');
		}

		/**
		 * @Route("/properties/design", name="properties_design")
		 */
		public function designAction(Request $request){
//			$this->addFlash('success','Primero debe guardar la propiedad para poder continuar con la creacion!!!');
//			$this->addFlash('info','Test flash message');
//			$this->addFlash('error','Test flash message');
//			$this->addFlash('warning','Test flash message');

			$mls_id = $request->get('mls_id');
			$property_id = $request->get('property_id');
			$user = $this->getUser();

			if($mls_id){
				$mls_property = $this->getBusiness()->getMlsProperty($mls_id);
				$new_property = new Property($user);
				$property = $this->getBusiness()->propertyApiMapper($mls_property, $new_property);
			}
			else if($property_id){
				$property = $this->getDoctrine()
					 							 ->getRepository('DashboardBundle:Property')
											   ->find($property_id);
			}
			else{
				$property = new Property($user);
			}

			$property_form = $this->createForm(PropertyType::class, $property);

			return $this->render('DashboardBundle:Properties:design.html.twig', array(
				'property' => $property,
				'property_form' => $property_form->createView()
			));
		}

    /**
     * @Route("/properties/mls", name="properties_mls")
     */
    public function mlsAction(Request $request){
			$properties = $this->getBusiness()->getMlsProperties();
			return $this->render('DashboardBundle:Properties:mls.html.twig', array(
				'properties' => $properties
			));
    }
}
