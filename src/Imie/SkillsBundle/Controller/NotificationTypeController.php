<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\NotificationType;
use Imie\SkillsBundle\Form\NotificationTypeType;

class NotificationTypeController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:NotificationType');
        $notificationTypes = $repo->getNotificationTypesOrderedById();

        return $this->render('ImieSkillsBundle:NotificationType:index.html.twig', array('notificationTypes' => $notificationTypes));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:NotificationType');
        $notification = $repo->findOneById($id);

        return $this->render('ImieSkillsBundle:NotificationType:details.html.twig', array('notification' => $notification));
    }



    public function addAction(Request $req) {
        $notification = new NotificationType();

        $form = $this->createForm(new NotificationTypeType(), $notification, array(
            'action' => $this->generateUrl('imie_skills_notification_type_add')
        ));

        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($notification);
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'NotificationType ajouté');
                return $this->redirect($this->generateUrl('imie_skills_notification_type_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'ajout :'
                        . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:NotificationType:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function deleteAction($id, Request $req) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:NotificationType');
        $notificationTypeToDelete = $repo->getNotificationTypeById($id);

        try {
            $em->remove($notificationTypeToDelete);
            $em->flush();
            $req->getSession()->getFlashBag()->add('success', 'Type de notification supprimé');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
        }
        return $this->redirect($this->generateUrl('imie_skills_notification_type_index'));
    }

}
