<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\User;
use Imie\SkillsBundle\Entity\UserSkill;
use Imie\SkillsBundle\Form\UserType;
use Imie\SkillsBundle\Form\UserSkillType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Imie\SkillsBundle\Form\UserModifyType;

class UserController extends Controller {

    public function indexAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');
        $users = $repo->getUsersOrderedById();
        return $this->render('ImieSkillsBundle:User:index.html.twig', array('users' => $users));
    }

    public function addAction(Request $req) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $user = new User();

        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('imie_skills_user_add')
        ));

        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $user->setUserFullName();
                $isAdmin = array($form->get('isAdmin')->getData());
                foreach ($isAdmin as $valid) {
                    if ($valid === true) {

                        $user->addRole("ROLE_ADMIN");
                        $user->setSuperAdmin(true);
                    }
                }
                if ($user->getImage()) {
                    $user->getImage()->setImageAlt($user->getUserFullName());
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
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
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

    //update skill assigned
    public function modifySkillAction(Request $req, $id) {
        if ($id != $this->get('security.token_storage')->getToken()->getUser()->getId()) {
            if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                throw new AccessDeniedException();
            }
        }
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:UserSkill');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $userSkillToModify = $repo->findOneById($id);
        $form = $this->createForm(new UserSkillType(), $userSkillToModify, array(
            'action' => $this->generateUrl('imie_skills_user_modifySkill', array(
                'id' => $id
            ))
        ));
        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $userSkillToModify->setSkill($form->get('skill')->getData());
                $userSkillToModify->setLevel($form->get('level')->getData()->getLevel());

                $em->persist($userSkillToModify);
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'Utilisateur modifié');
                return $this->redirect($this->generateUrl('imie_skills_user_details', array(
                                    'id' => $currentUser
                )));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'ajout :'
                        . PHP_EOL . $e->getMessage());
            }
        }
        return $this->render('ImieSkillsBundle:UserSkill:modifySkill.html.twig', array(
                    'form' => $form->createView(),
                    'id' => $id
        ));
    }

    //delete skill assigned
    public function deleteSkillAction(Request $req, $id) {
        if ($id != $this->get('security.token_storage')->getToken()->getUser()->getId()) {
            if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                throw new AccessDeniedException();
            }
        }
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
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');

        $user = $repo->getUserById($id);

        return $this->render('ImieSkillsBundle:User:details.html.twig', array(
                    'user' => $user
        ));
    }

    public function modifyAction(Request $req, $id) {

        if ($id != $this->get('security.token_storage')->getToken()->getUser()->getId()) {
            if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                throw new AccessDeniedException();
            }
        }
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');
        $userToModify = $repo->findOneById($id);
        if($this->get('security.context')->isGranted('ROLE_ADMIN')){
            $type = new UserType();
        } else {
            $type = new UserModifyType();
        }
        $form = $this->createForm($type, $userToModify, array(
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
                return $this->redirect($this->generateUrl('imie_skills_user_details', array(
                    'id' => $id
                )));
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
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
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
