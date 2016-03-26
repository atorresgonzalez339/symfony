<?php

namespace DashboardBundle\Repository;

use CommonBundle\Repository\BaseRepository;

class ContactRepository extends BaseRepository{

    public function findAll($offset = null, $limit = null) {
    }

    public function findByID($id) {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder = $queryBuilder->select('l')
            ->from('DashboardBundle:Contact', 'l')
            ->where('l.id = :id')
            ->setParameter(':id', $id);

        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) return $result[0];
        return null;
    }

    public function findByIDs($ids) {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder();

        $queryBuilder = $queryBuilder->select('l')
                ->from('DashboardBundle:Contact', 'l')
                ->where('l.id IN (:ids)')
                ->setParameter(':ids', $ids);
        return $queryBuilder->getQuery()->getResult();
    }
}
