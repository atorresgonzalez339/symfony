<?php

namespace DashboardBundle\Business;

use CommonBundle\Business\BaseBusiness;
use Doctrine\ORM\EntityManager;

class ContactListBusiness extends BaseBusiness {
	
    public function __construct(EntityManager $em) {
      parent::__construct($em);
    }

    public function findByID($id) {
        return $this->getRepository("DashboardBundle", "ContactList")->findByID($id);
    }

    public function removeAll($ids) {
        try {
            $entities = $this->getRepository("DashboardBundle", "ContactList")->findByIDs($ids);
            parent::removeAll($entities);
            return true;
        } catch (\Exception $exc) {
            return false;
        }
    }
}