<?php

namespace DashboardBundle\Business;

use CommonBundle\Business\BaseBusiness;
use DashboardBundle\Entity\Property;
use DashboardBundle\Entity\PropertyPhoto;

class PropertyBusiness extends BaseBusiness {

    private $container;

    public function __construct($em, $container) {
      parent::__construct($em);
      $this->container = $container;
    }

    public function saveProperty(Property $property){
      $this->saveData($property);
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

      $uploader = $this->container->get('speicher210_cloudinary.uploader');

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
        'Exterior Features: ' . $data['property']['exteriorFeatures']);
      //$property->setType($data['property']['type']);
      $property->setLeaseTerm($data['leaseTerm']);
      $property->setBedrooms($data['property']['bedrooms']);
      $property->setBathrooms($data['property']['bathsFull'] + $data['property']['bathsHalf']);
      $property->setUnitSize($data['property']['lotSize']);
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

      if(!empty($data['photos'])){
        foreach($data['photos'] as $photo){
          $result = $uploader->upload($photo, array('folder' => 'properties'));
          $propertyPhoto = new PropertyPhoto($property);
          $propertyPhoto->setPhotoId($result['public_id']);
          $propertyPhoto->setPhotoUrl($result['url']);
          $property->addPhoto($propertyPhoto);
        }
      }

      $this->saveProperty($property);
      return $property;
    }

    public function removePhoto(Property $property, $photo_id){
      $cloudinaryApi = $this->container->get('speicher210_cloudinary.api');
      foreach($property->getPhotos() as $photo){
        if($photo->getPhotoId() == $photo_id){
          $this->getEM()->remove($photo);
          $this->getEM()->flush();
          $cloudinaryApi->delete_resources(array($photo_id));
          break;
        }
      }
    }

}