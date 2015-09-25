<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\User;
use Imie\SkillsBundle\Entity\UserSkill;
use Imie\SkillsBundle\Form\UserType;
use Imie\SkillsBundle\Form\UserSkillType;

class UserController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');
        $users = $repo->getUsersOrderedById();
        return $this->render('ImieSkillsBundle:User:index.html.twig', array('users' => $users));
    }

    public function addAction(Request $req) {
        $user = new User();

        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('imie_skills_user_add')
        ));

        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $user->setUserFullName();

                $em->persist($user);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_user_add'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                echo $e->getMessage();
            }
        }

        return $this->render('ImieSkillsBundle:User:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function addSkillAction(Request $req) {
        $userSkill = new UserSkill();

        $form = $this->createForm(new UserSkillType(), $userSkill, array(
            'action' => $this->generateUrl('imie_skills_user_addSkill')
        ));

        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $currentUser = $this->get('security.token_storage')->getToken()->getUser();
                
                $repo = $em->getRepository('ImieSkillsBundle:User');
                $user = $repo->getUserById($currentUser->getId());
                $userSkill->setUserId($user->getId());
                $userSkill->setSkillId($form->get('skillId')->getData()->getId());
                
                
                
                $user->addSkill($form->get('skillId')->getData()->getSkillName(), $form->get('level')->getData());

                $em->persist($userSkill);
                $em->flush();
                
                return $this->redirect($this->generateUrl('imie_skills_user_addSkill'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                echo $e->getMessage();
            }
        }

        return $this->render('ImieSkillsBundle:UserSkill:addSkill.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');

        $user = $repo->getUserById($id);
        $currentUser = $this->get('security.token_storage')->getToken()->getUser()->getId();

        return $this->render('ImieSkillsBundle:User:details.html.twig', array(
                    'user' => $user,
                    'currentUser' => $currentUser));
    }

    public function modifyAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');
        $userToModify = $repo->findOneById($id);
        $form = $this->createForm(new UserType(), $userToModify, array(
            'action' => $this->generateUrl('imie_skills_user_modify', array(
                'id' => $id
            ))
        ));
        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $userToModify->setUserFullName();
                $skills = $form->get('skills')->getData();

                foreach ($skills as $skill) {
                    $userToModify->addSkill($skill);
                }

                $em->persist($userToModify);
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'Utilisateur modifié');
                return $this->redirect($this->generateUrl('imie_skills_user_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'ajout :'
                        . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:User:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function deleteAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('ImieSkillsBundle:User');
        $userToDelete = $userRepo->getUserById($id);

        try {
            $em->remove($userToDelete);
            $em->flush();
            $req->getSession()->getFlashBag()->add('success', 'Utilisateur supprimé');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
        }
        return $this->redirect($this->generateUrl('imie_skills_user_index'));
    }

}
