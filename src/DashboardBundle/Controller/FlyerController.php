<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use DashboardBundle\Form\FlyerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use DashboardBundle\Entity\Flyer;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class FlyerController extends BaseController
{
  private $serviceName = 'dashboard.flyer.business';

  public function getBusiness()
  {
    return parent::findBusiness($this->serviceName);
  }

  /**
   * @Route("/flyer", name="flyer_index")
   */
  public function indexAction(Request $request)
  {
    $source = new Entity('DashboardBundle:Flyer');
    $grid = $this->get('grid');
    $grid->setSource($source);
    $grid->hideColumns(array('id'));
    $grid->addMassAction(new DeleteMassAction());
    $grid->setLimits($this->container->getParameter('admin.paginator.limits.config'));

    if ($request->isXmlHttpRequest()) {
      return $grid->getGridResponse('DashboardBundle:Flyer:indexAjax.html.twig');
    }
    if ($grid->isReadyForRedirect()) {
      return new RedirectResponse($grid->getRouteUrl());
    }

    return $grid->getGridResponse('DashboardBundle:Flyer:index.html.twig');
  }

  /**
   * @Route("/flyer/options", name="flyer_options")
   */
  public function optionsAction(Request $request)
  {
    $action = $request->get('action');
    $messageInfoNotSelected = "You should select a flyer in order to continue.";
    $indexRouting = "flyer_index";
    $flyer_id = $this->getFirstSelectedGridItem();
    if (!$flyer_id) {
      $this->addFlash('info', $messageInfoNotSelected);
      return $this->redirect($this->generateUrl($indexRouting));
    }

    switch ($action) {
      case 'edit':
          $route = 'flyer_design';
        break;
      case 'delete':
          $route = 'flyer_remove';
        break;
      default:
          $route = 'flyer_design';
        break;
    }

    return $this->redirectToRoute($route, array('flyer_id' => $flyer_id));
  }

  /**
   * @Route("/flyer/design", name="flyer_design")
   */
  public function designAction(Request $request)
  {

    $user = $this->getUser();

    if ($request->get('flyer_id')) {
      $flyer_id = $request->get('flyer_id');
      $flyer = $this->getDoctrine()
        ->getRepository('DashboardBundle:Flyer')
        ->find($flyer_id);
      $property = $flyer->getProperty();
      $template = $flyer->getTemplate();
    } else {
      $property_id = $request->get('property_id');
      $template_id = $request->get('template_id');

      $property = $this->getDoctrine()
        ->getRepository('DashboardBundle:Property')
        ->find($property_id);

      $template = $this->getDoctrine()
        ->getRepository('DashboardBundle:Template')
        ->find($template_id);

      $flyer = new Flyer($user, $property, $template);
    }

    $flyer_form = $this->createForm(FlyerType::class, $flyer);

    $photos = $property->getPhotos();

    if ($flyer->getId()) {
      $flyer_view = $flyer->getHtmlEdit();
    } else {
      $flyer_view = $this->renderView('DashboardBundle:Themes:default2.html.twig', array(
        'property' => $property,
        'photos' => $photos,
        'flyer' => $flyer,
        'title' => $property->getName() ? $property->getName() : 'Title Here',
        'subtitle' => 'Subtitle Here',
        'address' => $property->getAddress() ? $property->getAddress() : 'Address Here'
      ));
    }

    return $this->render('DashboardBundle:Flyer:design.html.twig', array(
      'flyer' => $flyer,
      'flyer_form' => $flyer_form->createView(),
      'property' => $property,
      'template' => $template,
      'flyer_view' => $flyer_view,
      'photos' => $photos
    ));

  }

  /**
   * @Route("/flyer/save", name="flyer_save")
   */
  public function save(Request $request)
  {

    $user = $this->getUser();

    $property_id = $request->get('property_id');
    $template_id = $request->get('template_id');
    $flyer_id = $request->get('flyer_id');
    $go_to_send = $request->get('go_to_send');

    $property = $this->getDoctrine()
      ->getRepository('DashboardBundle:Property')
      ->find($property_id);

    $template = $this->getDoctrine()
      ->getRepository('DashboardBundle:Template')
      ->find($template_id);

    if ($flyer_id) {
      $flyer = $this->getDoctrine()
        ->getRepository('DashboardBundle:Flyer')
        ->find($flyer_id);
    } else {
      $flyer = new Flyer($user, $property, $template);
    }

    $flyer_form = $this->createForm(FlyerType::class, $flyer);
    $flyer_form->handleRequest($request);

    if ($flyer_form->isValid()) {
      $this->getBusiness()->saveFlyer($flyer);

      if (!$go_to_send) {
        $this->addFlash('success', 'Flyer was saved');
        return $this->redirectToRoute('flyer_design', array(
          'flyer_id' => $flyer_id
        ));
      } else {
        return $this->redirectToRoute('send_flyer_preview', array(
          'flyer_id' => $flyer_id
        ));
      }

    }

    die('invalid');

  }

  /**
   * @Route("/flyer/image_base64", name="flyer_image_base64")
   */
  public function getImageBase64Action(Request $request)
  {

    $cloudinaryApi = $this->get('speicher210_cloudinary.api');

    $photoId = $request->get('photoId');
    $width = $request->get('width');
    $height = $request->get('height');
    $crop = $request->get('crop');
    $format = $request->get('format');

    $img = $cloudinaryApi->resource($photoId, array(
      'width' => $width,
      'height' => $height,
      'crop' => $crop,
      'format' => $format
    ));

    $thumb = \PhpThumb_Factory::create($img['url']);
    $data = "data:image/png;base64,";
    $data .= base64_encode($thumb->getImageAsString());

    return new JsonResponse(array('img' => $data));

  }

  /**
   * @Route("/flyer/view_online", name="flyer_view_online")
   */
  public function viewOnlineAction(Request $request)
  {

    $flyer_id = $request->get('flyer_id');

    $flyer = $this->getDoctrine()
      ->getRepository('DashboardBundle:Flyer')
      ->find($flyer_id);

    if (!$flyer) {
      throw new ResourceNotFoundException();
    }

    return $this->render('DashboardBundle:Flyer:view_online.html.twig', array(
      'flyer' => $flyer,
    ));

  }
}
