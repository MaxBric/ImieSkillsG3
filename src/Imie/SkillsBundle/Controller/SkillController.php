<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Skill;
use Imie\SkillsBundle\Form\SkillType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SkillController extends Controller {

    public function indexAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $skills = $this->getDoctrine()
                ->getManager()
                ->getRepository('ImieSkillsBundle:Skill')
                ->getSkillsOrderedByName();

        return $this->render('ImieSkillsBundle:Skill:index.html.twig', array(
                    'skills' => $skills
        ));
    }

    public function addAction(Request $req) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $skill = new Skill();

        $form = $this->createForm(new SkillType(), $skill, array(
            'action' => $this->generateUrl('imie_skills_skill_add')
        ));

        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($skill);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_skill_add'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                echo $e->getMessage();
            }
        }

        return $this->render('ImieSkillsBundle:Skill:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function modifyAction(Request $req, $id) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:Skill');
        $skill = $repo->findOneById($id);
        $form = $this->createForm(new SkillType(), $skill, array(
            'action' => $this->generateUrl('imie_skills_skill_modify', array(
                'id' => $id
            ))
        ));
        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'Compétence modifiée');
                return $this->redirect($this->generateUrl('imie_skills_skill_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'ajout :'
                        . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:Skill:update.html.twig', array(
                    'form' => $form->createView(),
                    'id' => $id
        ));
    }

    public function deleteAction(Request $req, $id) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $skillRepo = $em->getRepository('ImieSkillsBundle:Skill');
        $skillToDelete = $skillRepo->getSkillById($id);

        try {
            $em->remove($skillToDelete);
            $em->flush();
            $req->getSession()->getFlashBag()->add('success', 'Compétence supprimée');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
        }
        return $this->redirect($this->generateUrl('imie_skills_skill_index'));
    }

}
