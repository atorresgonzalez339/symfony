<?php

namespace DashboardBundle\Business;

use CommonBundle\Business\BaseBusiness;

class UtilsBusiness extends BaseBusiness{

		public function __construct(EntityManager $em) {
			parent::__construct($em);
		}

		public function upladImage($img, $folder = null){
			$uploader = $this->container->get('speicher210_cloudinary.uploader');
      return $uploader->upload($img, array('folder' => $folder));
		}

}