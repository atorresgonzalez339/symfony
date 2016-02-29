<?php

namespace UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class UserProfileRepository extends EntityRepository
{

  public function findByUserId($user_id){
    return $this->createQueryBuilder('p')
      ->where('p.user = :user_id')
      ->setParameter('user_id', $user_id)
      ->getQuery()
      ->getOneOrNullResult();
  }
}