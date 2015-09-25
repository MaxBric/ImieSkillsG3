<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Level;
use Imie\SkillsBundle\Form\LevelType;

class LevelController extends Controller
{
  public function indexAction()
  {
    $levels = $this->getDoctrine()
                ->getManager()
                ->getRepository('ImieSkillsBundle:Level')
                ->getLevelsOrderedById();

        return $this->render('ImieSkillsBundle:Level:index.html.twig', array(
                    'levels' => $levels
        ));
  }

  public function addAction(Request $req)
  {
    $level = new Level();

    $form = $this->createForm(new LevelType(), $level, array(
      'action' => $this->generateUrl('imie_skills_level_add')
    ));

    $form->handleRequest($req);
    if ($form->isValid()) {
      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($level);
        $em->flush();
        return $this->redirect($this->generateUrl('imie_skills_level_add'));
      } catch (\Doctrine\DBAL\DBALException $e) {
        echo $e->getMessage();
      }
    }

    return $this->render('ImieSkillsBundle:Level:add.html.twig', array(
      'form' => $form->createView()
    ));
  }

  public function deleteAction(Request $req, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $levelRepo = $em->getRepository('ImieSkillsBundle:Level');
    $levelToDelete = $levelRepo->getLevelById($id);

    try {
      $em->remove($levelToDelete);
      $em->flush();
      $req->getSession()->getFlashBag()->add('success', 'level supprimée');
    } catch (\Doctrine\DBAL\DBALException $e) {
      $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
      . PHP_EOL . $e->getMessage());
    }
    return $this->redirect($this->generateUrl('imie_skills_level_index'));
  }

}
