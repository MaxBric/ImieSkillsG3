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
        $notifications = $repo->getLastNotificationsOrderedByDate();

        return $this->render('ImieSkillsBundle:Notification:index.html.twig', array('notifications' => $notifications));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:Notification');
        $notification = $repo->findOneById($id);

        return $this->render('ImieSkillsBundle:Notification:details.html.twig', array('notification' => $notification));
    }

    public function invitationAction() {
        try {
            $em = $this->getDoctrine()->getManager();
            //user
            $repoUser = $em->getRepository('ImieSkillsBundle:User');
            $currentUser = $this->get('security.token_storage')->getToken()->getUser();
            $user = $repo->getUserById($currentUser->getId());
            
            $userNotification->setNotificationUSer($user);
            $currentUser->addNotifications($userNotification);
            
            //project
            $repoProject = $em->getRepository('ImieSkillsBundle:Project');
//            $currentProject= $t
            
            $em->persist($userNotification);
            $em->flush();
            return $this->redirect($this->generateUrl('imie_skills_user_addSkill'));
        } catch (\Doctrine\DBAL\DBALException $e) {
            echo $e->getMessage();
        }
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
                $em->persist($notification);
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'Notification ajouté');
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
        $notificationToDelete = $repo->findOneById($id);

        try {
            $em->delete($notificationToDelete);
            $em->flush();
            $req->getSession()->getFlashBag()->add('success', 'Notification supprimée');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
        }
        return $this->redirect($this->generateUrl('imie_skills_notification_index'));
    }

}
