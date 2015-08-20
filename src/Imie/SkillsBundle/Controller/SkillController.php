<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Skill;
use Imie\SkillsBundle\Form\SkillType;

class SkillController extends Controller
{
    public function indexAction($id)
    {
        //return $this->render('ImieSkillsBundle:Profile:myProfile.html.twig', array('id' => $id));
    }

    public function addSkillAction(Request $req)
    {
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
}
