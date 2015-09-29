<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends EntityRepository {

    public function getNotificationsOrderedById() {
        return $this->createQueryBuilder('n')
                        ->orderBy('n.id')
                        ->getQuery()
                        ->getResult();
    }
    
    public function getNotifs(){
        return $this->createQueryBuilder('n')
                ->join('n.notificationSender', 'sender')
                ->addSelect('sender')
                ->join('n.notificationAdressee', 'adressee')
                ->addSelect('adressee')
                ->join('n.notificationProject', 'project')
                ->addSelect('project')
//                ->where("n.notificationAdressee =:id")
                ->getQuery()
                ->getResult();
    }
    
    public function getLastNotificationsOrderedByDate($id) {
        return $this->createQueryBuilder('n')
                        ->setMaxResults(3)
                        ->orderBy('n.notificationDate', 'DESC')
                        ->where('n.notificationAdressee =: id')
                        ->getQuery()
                        ->getResult();
    }

    public function getNotificationById($id) {
        return $this->createQueryBuilder('n')
                        ->where('n.id =:id')
                        ->setParameter('id', $id)
                        ->getQuery()
                        ->getSingleResult();
    }

}
