<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class FlyerController extends Controller
{
    /**
     * @Route("/flyer", name="flyer_index")
     */
    public function indexAction(Request $request){

      $user = $this->getUser();

      $flyers = $this->getDoctrine()
              ->getRepository('DashboardBundle:Flyer')
              ->findBy(array('user_id' => $user->getId()));

      return $this->render('DashboardBundle:Flyer:index.html.twig', array(
                            'flyers' => $flyers
                           ));
    }

    /**
     * @Route("/flyer/new", name="flyer_new")
     */
    public function newAction(Request $request){
      $mls_id = $request->get('id_property');
      $template = $request->get('id_template');
      $property = $this->getProperty($mls_id);

      $photos = [];

      foreach($property['photos'] as $photo){
        $thumb = \PhpThumb_Factory::create($photo);
        $img =  'data:image/png;base64,' . base64_encode($thumb->getImageAsString());
        $photos[] = $img;
      }

      // echo "<pre>";
      // print_r($property);

      return $this->render('DashboardBundle:Flyer:edit.html.twig', array(
        'property' => $property,
        'photos' =>  $photos
      ));
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
