<?php

namespace DashboardBundle\Controller;

use DashboardBundle\Entity\PropertyPhoto;
use DashboardBundle\Form\PropertyPhotoType;
use DashboardBundle\Form\PropertyType;
use DashboardBundle\Entity\Property;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use CommonBundle\Controller\BaseController;

class PropertyController extends BaseController
{

  private $serviceName = 'dashboard.property.business';

  public function getBusiness()
  {
    return parent::findBusiness($this->serviceName);
  }

  /**
   * @Route("/properties", name="properties_index")
   */
  public function indexAction(Request $request)
  {
    $source = new Entity('DashboardBundle:Property');
    $grid = $this->get('grid');
    $grid->setSource($source);
    $grid->hideColumns(array('id'));
    $grid->addMassAction(new DeleteMassAction());
    $grid->setLimits(array(8,16,24,32,40));

    if ($request->isXmlHttpRequest()) {
      return $grid->getGridResponse('DashboardBundle:Properties:indexAjax.html.twig');
    }
    if ($grid->isReadyForRedirect()) {
      return new RedirectResponse($grid->getRouteUrl());
    }

    return $grid->getGridResponse('DashboardBundle:Properties:index.html.twig');
  }

  /**
   * @Route("/properties/show", name="properties_show")
   */
  public function showAction(Request $request) {
    $messageInfoNotSelected = "Select one Property in the list";
    $indexRouting = "properties_index";
    $idSelected = $this->getFiertSelectetGridItem();
    if (!$idSelected) {
      $this->addFlash('info', $messageInfoNotSelected);
      return $this->redirect($this->generateUrl($indexRouting));
    }
    $entity = $this->getDoctrine()->getRepository('DashboardBundle:Property')->find($idSelected);
    if (!$entity) {
      return $this->addFlash('info', $messageInfoNotSelected, $indexRouting);
    }
    return $this->render('DashboardBundle:Properties:show.html.twig', array(
        'property' => $entity,
    ));
  }

    /**
   * @Route("/properties/design", name="properties_design")
   */
  public function designAction(Request $request)
  {
    $mls_id = $request->get('mls_id');
    $property_id = $request->get('property_id');
    $user = $this->getUser();

    if($request->isMethod('POST')){
      $property_id = $this->getFirstSelectedGridItem();
      return $this->redirectToRoute('properties_design', array('property_id' => $property_id));
    }

    //Design a property from MLS
    if ($mls_id) {
      $mls_property = $this->getBusiness()->getMlsProperty($mls_id);
      $new_property = new Property($user);
      $property = $this->getBusiness()->propertyApiMapper($mls_property, $new_property);
      $property_id = $property->getId();
      return $this->redirectToRoute('properties_design', array('property_id' => $property_id));
    } //Design an existing property
    else if ($property_id) {
      $property = $this->getDoctrine()
        ->getRepository('DashboardBundle:Property')
        ->find($property_id);
    } //Design an empty property
    else {
      $property = new Property($user);
      $property->setName('New Property');
      $this->getBusiness()->saveProperty($property);
      $property_id = $property->getId();
      return $this->redirectToRoute('properties_design', array('property_id' => $property_id));
    }

    $property_form = $this->createForm(PropertyType::class, $property);
    $property_photo_form = $this->createForm(PropertyPhotoType::class, new PropertyPhoto($property));

    return $this->render('DashboardBundle:Properties:design.html.twig', array(
      'mls_id' => $mls_id,
      'property_id' => $property_id,
      'property' => $property,
      'property_form' => $property_form->createView(),
      'property_photo_form' => $property_photo_form->createView()
    ));
  }

  /**
   * @Route("/properties/save", name="properties_save")
   */
  public function saveAction(Request $request)
  {

    $property_id = $request->get('property_id');
    if($property_id){
      $property = $this->getDoctrine()
        ->getRepository('DashboardBundle:Property')
        ->find($property_id);
    }
    else{
      $property = new Property($user);
    }

    $property_form = $this->createForm(PropertyType::class, $property);
    $mls_id = $request->get('mls_id');

    $property_form->handleRequest($request);

    if ($property_form->isValid()) {
      $this->getBusiness()->saveProperty($property);
      $this->addFlash('success', 'Property saved');
      return $this->redirect($this->generateUrl('properties_design', array('property_id' => $property->getId())));
    }

    $this->addFlash('error', 'Invalid data');
    return $this->redirect($this->generateUrl('properties_design', array('mls_id' => $mls_id)));

  }

  /**
   * @Route("/properties/remove", name="properties_remove")
   */
  public function removeAction(Request $request)
  {
    $property_id = $this->getFirstSelectedGridItem();

    $property = $this->getDoctrine()
      ->getRepository('DashboardBundle:Property')
      ->find($property_id);

    $this->getBusiness()->getEM()->remove($property);
    $this->getBusiness()->getEM()->flush();

    $this->addFlash('success', 'Property deleted');

    return $this->redirect($this->generateUrl('properties_index'));
  }

  /**
   * @Route("/properties/mls", name="properties_mls")
   */
  public function mlsAction(Request $request)
  {
    $properties = $this->getBusiness()->getMlsProperties();
    return $this->render('DashboardBundle:Properties:mls.html.twig', array(
      'properties' => $properties
    ));
  }

  /**
   * @Route("/properties/upload_photo", name="properties_upload_photo")
   */
  public function uploadPhotoAction(Request $request)
  {
    $property_id = $request->get('property_id');
    $property = $this->getDoctrine()
      ->getRepository('DashboardBundle:Property')
      ->find($property_id);

    $propertyPhoto = new PropertyPhoto($property);
    $property_photo_form = $this->createForm(PropertyPhotoType::class, $propertyPhoto);

    $property_photo_form->handleRequest($request);

    if ($property_photo_form->isValid()) {
      $property->addPhoto($propertyPhoto);
      $this->getBusiness()->saveProperty($property);
      return new JsonResponse(array('status' => 'ok'));
    }
    else{
      return new JsonResponse(array('status' => 'error'));
    }
  }

  /**
   * @Route("/properties/delete_photo", name="properties_delete_photo")
   */
  public function deletePhotoAction(Request $request)
  {
    $property_id = $request->get('property_id');
    $photo_id = $request->get('photo_id');
    $property = $this->getDoctrine()
      ->getRepository('DashboardBundle:Property')
      ->find($property_id);

    if ($property) {
      $this->getBusiness()->removePhoto($property, $photo_id);
      return new JsonResponse(array('status' => 'ok'));
    }
    else{
      return new JsonResponse(array('status' => 'error'));
    }
  }
}
