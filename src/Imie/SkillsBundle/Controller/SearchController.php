<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Search;
use Imie\SkillsBundle\Form\SearchType;

class SearchController extends Controller {
    public $i;

  public function indexAction(Request $req) {
    $search = new Search();

    $form = $this->createForm(new SearchType(), $search, array(
      'action' => $this->generateUrl('imie_skills_search')
    ));
    $form->handleRequest($req);

    if ($form->isValid()) {
      try {
        $em = $this->getDoctrine()->getManager();
        $em->persist($search);
        for ($this->i=0; $this->i < sizeof($search->type); $this->i++) {
          // var_dump($search);die();
          if ($search->type[$this->i] === 'User') {
            $userRepo = $em->getRepository('ImieSkillsBundle:User');
            array_push($search->results, $userRepo->getUsersByNames($form["text"]->getData()));
          }
          if ($search->type[$this->i] === 'Project') {
            $projectRepo = $em->getRepository('ImieSkillsBundle:Project');
            array_push($search->results, $projectRepo->getProjectsByNames($form["text"]->getData()));
          }
          if ($search->type[$this->i] === 'Skill') {
            $skillRepo = $em->getRepository('ImieSkillsBundle:Skill');
            array_push($search->results, $skillRepo->getSkillsByNames($form["text"]->getData()));
          }
        }
        var_dump($search);die();
        return $this->render('ImieSkillsBundle:Search:index.html.twig', array(
          'search' => $search,
          'form' => $form->createView()
        ));
      } catch (\Doctrine\DBAL\DBALException $e) {
        echo $e->getMessage();
      }
    }
    return $this->render('ImieSkillsBundle:Search:index.html.twig', array(
      'search' => $search,
      'form' => $form->createView()
    ));
  }



}
