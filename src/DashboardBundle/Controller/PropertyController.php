<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends Controller
{
    /**
     * @Route("/properties", name="properties_index")
     */
    public function indexAction(Request $request){
			$properties = $this->getProperties();
      $property_type = 'mls';
			return $this->render('DashboardBundle:Properties:index.html.twig', array(
        'properties' => $properties,
        'property_type' => $property_type
      ));
    }

    public function getProperties(){
			$username = "simplyrets";
			$password = "simplyrets";
			$remote_url = 'https://api.simplyrets.com/properties';

			//$output = $this->get('api_caller')->call(new HttpGetJson($remote_url , $parameters));

			$ch = curl_init($remote_url);

    	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Basic " . base64_encode("$username:$password"),
    	));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$output = curl_exec($ch);
    	$result = json_decode($output, true);
    	curl_close($ch);

			// $lat = '25.7824618';
			// $lng = '-80.3011208';

			//$remote_url .= "?points=$lat,$lng";
			return $result;
		}
}
