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
        $notifications = $repo->getLastNotificationOrderedByDate();

        return $this->render('ImieSkillsBundle:Notification:index.html.twig', array('notifications' => $notifications));
    }

    public function detailAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:Notification');
        $notification = $repo->findOneById($id);

        return $this->render('ImieSkillsBundle:Notification:detail.html.twig', array('notification' => $notification));
    }


    public function addAction(Request $req){
        $notification = new Notification();

        $form = $this->createForm(new NotificationType(), $notification, array(
            'action' => $this->generateUrl('imie_notification_add')
        ));

        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($notification);
                $em->flush();
                return new Response('Slug généré : ' . $advert->getSlug());
                $req->getSession()->getFlashBag()->add('success', 'Produit ajouté');
                return $this->redirect($this->generateUrl('imie_notification_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'ajout :'
                        . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:Notification:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function removeAction($id, Request $req) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:Notification');
        $notificationToRemove = $repo->findOneById($id);

        try {
            $em->remove($notificationToRemove);
            $em->flush();
            $req->getSession()->getFlashBag()->add('success', 'Notification supprimé');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
        }
        return $this->redirect($this->generateUrl('imie_notification_index'));
    }

}
