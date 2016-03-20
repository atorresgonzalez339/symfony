<?php

namespace DashboardBundle\Controller;

use CommonBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;

use DashboardBundle\Entity\Flyer;

class FlyerController extends BaseController
{
    /**
     * @Route("/flyer", name="flyer_index")
     */
    public function indexAction(Request $request){
      $source = new Entity('DashboardBundle:Flyer');
      $grid = $this->get('grid');
      $grid->setSource($source);
      $grid->hideColumns(array('id'));
      $grid->addMassAction(new DeleteMassAction());
      $grid->setLimits($this->container->getParameter('admin.paginator.limits.config'));

      if ($request->isXmlHttpRequest()) {
        return $grid->getGridResponse('DashboardBundle:Flyer:indexAjax.html.twig');
      }
      if ($grid->isReadyForRedirect() ) {
        return new RedirectResponse($grid->getRouteUrl());
      }

      return $grid->getGridResponse('DashboardBundle:Flyer:index.html.twig');
    }

    /**
     * @Route("/flyer/design", name="flyer_design")
     */
    public function designAction(Request $request){

      $property_id = $request->get('property_id');
      $template_id = $request->get('id_template');
      $flyer_id = $request->get('flyer_id');
      $user = $this->getUser();

      if($request->isMethod('POST')){
        $flyer_id = $this->getFirstSelectetGridItem();
        $flyer = $this->getDoctrine()
                      ->getRepository('DashboardBundle:Flyer')
                      ->find($flyer_id);

        $property = $flyer->getProperty();
        $template = $flyer->getTemplate();

      }

      $photos = [];

      $property = $this->getDoctrine()
            ->getRepository('DashboardBundle:Property')
            ->find($property_id);

      $template = $this->getDoctrine()
        ->getRepository('DashboardBundle:Template')
        ->find($template_id);

      if($flyer_id){
        $flyer = $this->getDoctrine()
                     ->getRepository('DashboardBundle:Flyer')
                     ->find($flyer_id);
      }
      else{
        $flyer = new Flyer($user);
      }

      $fliyer_view = $this->renderView('DashboardBundle:Themes:default.html.twig');

      return $this->render('DashboardBundle:Flyer:create.html.twig', array(
        'flyer' => $flyer,
        'fliyer_view' => $fliyer_view,
        'photos' =>  $photos ? $photos : []
      ));
    }

    /**
     * @Route("/flyer/create", name="flyer_create")
     */
    public function createAction()
    {

    }

    /**
     * @Route("/eblast/update", name="eblast_update")
     */
    public function update(Request $request){
      $images = $request->get('images');
      $result = [];

      foreach($images as $img){
        $result[] = $this->uploadImg($img);
      }
      
      $response = new JsonResponse($result);
      return $response;
    }

    public function getProperty($id){
      $username = "simplyrets";
      $password = "simplyrets";
      $remote_url = 'https://api.simplyrets.com/properties/' . $id;

      $ch = curl_init($remote_url);
      
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Basic " . base64_encode("$username:$password"),
      ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $output = curl_exec($ch);
      $result = json_decode($output, true);
      curl_close($ch);

      return $result;
    }

    public function uploadImg($img = null){
      $uploader = $this->get('speicher210_cloudinary.uploader');
      return $uploader->upload($img, array('folder' => 'eblast'));
    }
}
