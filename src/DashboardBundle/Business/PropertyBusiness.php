<?php

namespace DashboardBundle\Business;

use DashboardBundle\Entity\Property;

class PropertyBusiness {
	
		private $container;

		public function __construct($container) {
        $this->container = $container;
    }

  public function getMlsProperties(){
    $username = "simplyrets";
    $password = "simplyrets";
    $remote_url = 'https://api.simplyrets.com/properties';

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

  public function getMlsProperty($id){
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

    public function propertyApiMapper($data, Property $property){
      $property->setName($data['property']['subdivision']);
      $property->setDescription($data['property']['lotDescription']);
      $property->setFeatures(
        'Style: ' . $data['property']['style'] . ' - ' .
        'View: ' . $data['property']['view'] . ' - ' .
        'Construction: ' . $data['property']['construction'] . ' - ' .
        'Accessibility: ' . $data['property']['accessibility'] . ' - ' .
        'Heating: ' . $data['property']['heating'] . ' - ' .
        'Laundry Features: ' . $data['property']['laundryFeatures'] . ' - ' .
        'Interior Features: ' .  $data['property']['interiorFeatures'] . ' - ' .
        'Exterior Features: ' . $data['property']['exteriorFeatures'] . ' - ');
      $property->setType($data['property']['type']);
      $property->setLeaseTerm($data['leaseTerm']);
      $property->setBedrooms($data['property']['bedrooms']);
      $property->setBathsFull($data['property']['bathsFull']);
      $property->setBathsHalf($data['property']['bathsHalf']);
      $property->setLotSize($data['property']['lotSize']);
      $property->setYearBuilt($data['property']['yearBuilt']);
      $property->setMlsId($data['mlsId']);
      $property->setAddress($data['address']['full']);
      $property->setUnit($data['address']['unit']);
      $property->setCity($data['address']['city']);
      $property->setState($data['address']['state']);
      $property->setCountry($data['address']['country']);
      $property->setPostalCode($data['address']['postalCode']);
      $property->setLat($data['geo']['lat']);
      $property->setLng($data['geo']['lng']);

      return $property;
    }

    public function uploadImg($img = null){
      $uploader = $this->get('speicher210_cloudinary.uploader');
      return $uploader->upload($img, array('folder' => 'eblast'));
    }

//    foreach($property['photos'] as $photo){
//      $thumb = \PhpThumb_Factory::create($photo);
//      $img =  'data:image/png;base64,' . base64_encode($thumb->getImageAsString());
//      $photos[] = $img;
//    }
}