<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RankRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RankRepository extends EntityRepository
{
  public function getRanksOrderedById() {
    return $this->createQueryBuilder('r')
    ->orderBy('r.id')
    ->getQuery()
    ->getResult();
  }
  public function getRanksById($ids) {
    $qb = $this->createQueryBuilder('r');
    $qb->where($qb->expr()->in('r.id', $ids));
    return $qb->getQuery()->getResult();
  }


  public function getRankById($id) {
    return $qb = $this->createQueryBuilder('r')
    ->where('r.id = :id')
    ->setParameter('id', $id)
    ->getQuery()
    ->getSingleResult();
  }
}