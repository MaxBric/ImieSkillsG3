<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\User;
use Imie\SkillsBundle\Form\UserType;

class UserController extends Controller
{
  public function indexAction($id)
  {
    return $this->render('ImieSkillsBundle:Profile:myProfile.html.twig', array('id' => $id));
  }

  public function addUserAction(Request $req)
  {
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
  public function detailUserAction($id) {
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('ImieSkillsBundle:User');

    $user = $repo->findOneBy($id);

    return $this->render('ImieSkillsBundle:User:detailUser.html.twig', array('user' => $user));
  }
  public function removeUserAction(Request $req, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $userRepo = $em->getRepository('ImieSkillsBundle:User');
    $userToDelete = $userRepo->findUserById($id);

    try {
      $em->remove($userToDelete);
      $em->flush();
      $req->getSession()->getFlashBag()->add('success', 'Utilisateur supprimé');
    } catch (\Doctrine\DBAL\DBALException $e) {
      $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
      . PHP_EOL . $e->getMessage());
    }
    return $this->redirect($this->generateUrl('imie_skills_homepage'));
  }
}
