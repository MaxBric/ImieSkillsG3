<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
* SkillRepository
*
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class SkillRepository extends EntityRepository
{
  public function getSkillsOrderedById() {
    return $this->createQueryBuilder('s')
    ->orderBy('s.id')
    ->getQuery()
    ->getResult();
  }

  public function getSkillsByNames($name) {
    return $this->createQueryBuilder('s')
    ->where('s.SkillName LIKE :name')
    ->setParameter('name', $name)
    ->getQuery()
    ->getResult();
  }

  public function getSkillsById($ids) {
      $qb = $this->createQueryBuilder('s');
      $qb->where($qb->expr()->in('s.id', $ids));
      return $qb->getQuery()->getResult();
  }


  public function getSkillById($id) {
    return $qb = $this->createQueryBuilder('s')
    ->where('s.id = :id')
    ->setParameter('id', $id)
    ->getQuery()
    ->getSingleResult();
  }
}
