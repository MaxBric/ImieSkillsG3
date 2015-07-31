<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Project;
use Imie\SkillsBundle\Form\ProjectType;

class ProjectController extends Controller
{
    public function indexAction()
    {
        // return $this->render('ImieSkillsBundle:Project:myProject.html.twig');
    }

    public function addProjectAction()
    {
      $project = new Project();
      $form = $this->createForm(new ProjectType(), $project, array(
          'action' => $this->generateUrl('imie_skills_project_add_project')
      ));
      return $this->render('ImieSkillsBundle:Project:addProject.html.twig', array(
                  'form' => $form->createView()
      ));
    }

    public function myProjectAction($id=1)
    {
      // a definir
    }
}
