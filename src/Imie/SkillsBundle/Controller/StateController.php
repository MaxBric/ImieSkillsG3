<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\State;
use Imie\SkillsBundle\Form\StateType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class StateController extends Controller {

    public function indexAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $states = $this->getDoctrine()
                ->getManager()
                ->getRepository('ImieSkillsBundle:State')
                ->getStatesOrderedById();

        return $this->render('ImieSkillsBundle:State:index.html.twig', array(
                    'states' => $states
        ));
    }

    public function addAction(Request $req) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $state = new State();
        $form = $this->createForm(new StateType(), $state, array(
            'action' => $this->generateUrl('imie_skills_state_add')
        ));

        $form->handleRequest($req);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($state);
                $em->flush();

                $req->getSession()->getFlashBag()->add('success', 'Etape créée !');

                return $this->redirect($this->generateUrl('imie_skills_state_add'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                echo $e->getMessage();
            }
        }
        return $this->render('ImieSkillsBundle:State:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function detailsAction($id) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:STate');

        $state = $repo->getStateById($id);

        return $this->render('ImieSkillsBundle:Project:details.html.twig', array('state' => $state));
    }

    public function modifyAction(Request $req, $id) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:State');
        $stateToModify = $repo->findOneById($id);
        $form = $this->createForm(new StateType(), $stateToModify, array(
            'action' => $this->generateUrl('imie_skills_state_modify', array(
                'id' => $id
            ))
        ));
        $form->handleRequest($req);

        if ($form->isValid()) {
            try {
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'Etape modifiée');
                return $this->redirect($this->generateUrl('imie_skills_state_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                        . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:State:update.html.twig', array(
                    'form' => $form->createView(),
                    'id' => $id
        ));
    }

    public function deleteAction(Request $req, $id) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('ImieSkillsBundle:State');

        $state = $repo->find($id);
        try {
            $em->remove($state);
            $em->flush();

            $req->getSession()->getFlashBag()->add('success', 'Etape supprimée !');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
        }

        return $this->redirect($this->generateUrl('imie_skills_state_index'));
    }

}
