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
        return $this->render('ImieSkillsBundle:User:me.html.twig', array('id' => $id));
    }

    public function addAction(Request $req)
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
}
