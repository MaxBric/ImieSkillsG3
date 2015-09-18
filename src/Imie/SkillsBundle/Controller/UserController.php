<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\User;
use Imie\SkillsBundle\Form\UserType;
use Imie\SkillsBundle\Form\UserModifyType;

class UserController extends Controller {

    public function indexAction() {
        // Pour récupérer le service UserManager du bundle
        $userManager = $this->get('fos_user.user_manager');

// Pour charger un utilisateur
        $user = $userManager->findUserBy(array('username' => 'winzou'));

// Pour modifier un utilisateur
        $user->setEmail('cetemail@nexiste.pas');
        $userManager->updateUser($user); // Pas besoin de faire un flush avec l'EntityManager, cette méthode le fait toute seule !
// Pour supprimer un utilisateur
//        $userManager->deleteUser($user);

// Pour récupérer la liste de tous les utilisateurs
//        $users = $userManager->findUsers();
    }

//  public function indexAction()
//  {
//    $em = $this->getDoctrine()->getManager();
//    $repo = $em->getRepository('ImieSkillsBundle:User');
//    $users = $repo->getUsersOrderedById();
//    return $this->render('ImieSkillsBundle:User:index.html.twig', array('users' => $users));
//  }

    public function addAction(Request $req) {
        $user = new User();

        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('imie_skills_user_add')
        ));

        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $user->setUserFullName();
                $em = $this->getDoctrine()->getManager();
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

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');

        $user = $repo->getUserById($id);

        return $this->render('ImieSkillsBundle:User:me.html.twig', array('user' => $user));
    }

    public function modifyAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:User');
        $userToModify = $repo->findOneById($id);
        $form = $this->createForm(new UserModifyType(), $userToModify, array(
            'action' => $this->generateUrl('imie_skills_user_modify', array(
                'id' => $id
            ))
        ));
        $form->handleRequest($req);
        if ($form->isValid()) {
            try {
                $user->setUserFullName();
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
        return $this->redirect($this->generateUrl('imie_skills_home'));
    }

}
