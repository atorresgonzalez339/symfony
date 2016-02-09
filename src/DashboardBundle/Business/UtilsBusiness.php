<?php

namespace DashboardBundle\Business;

class UtilsBusiness {
	
		private $container;

		public function __construct($container) {
        $this->container = $container;
    }

		public function upladImage($img, $folder = null){
			$uploader = $this->container->get('speicher210_cloudinary.uploader');
      return $uploader->upload($img, array('folder' => $folder));
		}

}