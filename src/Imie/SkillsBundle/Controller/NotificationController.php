<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Notification;
use Imie\SkillsBundle\Form\NotificationType;

class NotificationController extends Controller {

  public function indexAction() {
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('ImieSkillsBundle:Notification');
    $notifications = $repo->getNotifs();
    return $this->render('ImieSkillsBundle:Notification:index.html.twig', array('notifications' => $notifications));
  }
  
  public function detailsAction($id) {
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('ImieSkillsBundle:Notification');
    $notification = $repo->findOneById($id);
    return $this->render('ImieSkillsBundle:Notification:details.html.twig', array('notification' => $notification));
  }

  public function addAction(Request $req) {
    $notification = new Notification();
    $form = $this->createForm(new NotificationType(), $notification, array(
      'action' => $this->generateUrl('imie_skills_notification_add')
    ));
    $form->handleRequest($req);
    if ($form->isValid()) {
      try {
        $em = $this->getDoctrine()->getManager();
        $repoUser = $em->getRepository('ImieSkillsBundle:User');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $sender = $repoUser->getUserById($currentUser->getId());
        $notification->setNotificationSender($sender);
        $sender->addSentNotification($notification);
        $em->persist($notification);
        $em->flush();
        $req->getSession()->getFlashBag()->add('success', 'Notification ajoutée');
        return $this->redirect($this->generateUrl('imie_skills_notification_index'));
      } catch (\Doctrine\DBAL\DBALException $e) {
        $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'ajout :'
        . PHP_EOL . $e->getMessage());
      }
    }

    return $this->render('ImieSkillsBundle:Notification:add.html.twig', array(
      'form' => $form->createView()
    ));
  }

  public function deleteAction($id, Request $req) {
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('ImieSkillsBundle:Notification');
    $notificationToDelete = $repo->getNotificationById($id);
    try {
      $em->remove($notificationToDelete);
      $em->flush();
      $req->getSession()->getFlashBag()->add('success', 'Notification supprimée');
      return $this->redirect($this->generateUrl('imie_skills_notification_index'));
    } catch (\Doctrine\DBAL\DBALException $e) {
      $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
      . PHP_EOL . $e->getMessage());
    }
    return $this->redirect($this->generateUrl('imie_skills_notification_index'));
  }
}
