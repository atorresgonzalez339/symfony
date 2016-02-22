<?php

/**
 * @copyright (c) 2013, RALF
 * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
 * @version 1.0.0
 */

namespace CommonBundle\Business;

use RALF\CoreBundle\Anotaciones\Transaccional;
use Doctrine\ORM\EntityManager;

class BaseBusiness {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function setEM($em) {
        $this->em = $em;
    }

    /**
     * @return EntityManager
     */
    public function getEM() {
        return $this->em;
    }

    /**
     * @Transaccional
     */
    public function saveData($data) {
        $this->em->persist($data);
    }

    /**
     * @Transaccional
     */
    public function remove($data) {
        $this->em->remove($data);
    }

    public function removeAll($data) {

        foreach ($data as $item) {
            $this->em->remove($item);
        }
        $this->em->flush();
    }

    public function getRepository($bundle, $entity) {

        if (strstr($bundle, 'Bundle') == 'Bundle') {
            return $this->em->getRepository($bundle . ':' . $entity);
        } else {            
            return $this->em->getRepository($bundle . 'Bundle:' . $entity);
        }
    }

    public function getNormalizeRepository($bundlentity) {
        return $this->em->getRepository($bundlentity);
    }

    public function findAll($bundle, $entity) {
        return $this->getRepository($bundle, $entity)->findAll();
    }

    public function findBy($bundle, $entity, $criteria) {
        return $this->getRepository($bundle, $entity)->findBy($criteria);
    }
}

