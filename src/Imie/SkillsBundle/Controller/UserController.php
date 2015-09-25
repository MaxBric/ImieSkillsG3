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
                $tab = array($form->get('roles')->getData());

                foreach ($tab as $roles) {
                    foreach ($roles as $role) {
                        if ($role === "ROLE_ADMIN") {
                            $user->setSuperAdmin(true);
                        }
                    }
                }

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

    //assigne skill exist 
    public function addSkillAction(Request $req) {
        $userSkill = new UserSkill();

        $form = $this->createForm(new UserSkillType(), $userSkill, array(
            'action' => $this->generateUrl('imie_skills_user_addSkill')
        ));

        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $repo = $em->getRepository('ImieSkillsBundle:User');

                $currentUser = $this->get('security.token_storage')->getToken()->getUser();
                $user = $repo->getUserById($currentUser->getId());

                $userSkill->setUser($user);

                $userSkill->setSkill($form->get('skill')->getData());
                $userSkill->setLevel($form->get('level')->getData()->getLevel());
                $currentUser->addSkill($userSkill);

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

    //delete skill assigned
    public function deleteSkillAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:UserSkill');
        $userSkill = $repo->getUserSkillById($id);
        $currentUser = $this->get('security.token_storage')->getToken()->getUser()->getId();
        try {

            $em->remove($userSkill);
            $em->flush();
            $req->getSession()->getFlashBag()->add('success', 'Compétence supprimée');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
        }
        return $this->redirect($this->generateUrl('imie_skills_user_details', array(
        'id' => $currentUser
        )));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');

        $user = $repo->getUserById($id);

        return $this->render('ImieSkillsBundle:User:details.html.twig', array(
                    'user' => $user
                ));
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

                $em->persist($userToModify);
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'Utilisateur modifié');
                return $this->redirect($this->generateUrl('imie_skills_user_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'ajout :'
                        . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:User:modify.html.twig', array(
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
