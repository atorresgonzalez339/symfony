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

    public function addContact($entityContactList,$entityContact) {
        try {
            $em = $this->getEM();
            $entityContactList->addContact($entityContact);
            $em->persist($entityContactList);
            $em->flush();
            return true;
        } catch (\Exception $exc) {
            return false;
        }
    }

    public function removeContact($entityContactList,$entityContact) {
        try {
            $em = $this->getEM();
            $entityContactList->removeContact($entityContact);
            $em->persist($entityContactList);
            $em->flush();
            return true;
        } catch (\Exception $exc) {
            return false;
        }
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