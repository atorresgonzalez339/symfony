<?php

namespace DashboardBundle\Business;

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

}