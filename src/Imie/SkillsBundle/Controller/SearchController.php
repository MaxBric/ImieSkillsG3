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
            if ($skillRepo->getSkillByName($form["text"]->getData())) {
              $skillId  = $skillRepo->getSkillByName($form["text"]->getData())->getId();
              $userSkillRepo = $em->getRepository('ImieSkillsBundle:UserSkill');
              array_push($search->results, $skillRepo->getUsersBySkill($form["text"]->getData()));
            }
          }
        }
        return $this->render('ImieSkillsBundle:Search:index.html.twig', array(
          'form' => $form->createView(),
          'search' => $search
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
