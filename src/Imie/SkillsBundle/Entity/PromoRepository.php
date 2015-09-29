<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
* promoRepository
*
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class PromoRepository extends EntityRepository
{
  public function getPromosOrderedById() {
    return $this->createQueryBuilder('p')
    ->orderBy('p.course')
    ->getQuery()
    ->getResult();
  }
  public function getPromosById($ids) {
    $qb = $this->createQueryBuilder('p');
    $qb->where($qb->expr()->in('p.id', $ids));
    return $qb->getQuery()->getResult();
  }

  public function getPromoById($id){
    return $this->createQueryBuilder('p')
    ->where('p.id =: id')
    ->setParameter('id',$id)
    ->getQuery()
    ->getResult();
  }
}
