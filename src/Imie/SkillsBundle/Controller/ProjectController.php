<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Project;
use Imie\SkillsBundle\Form\ProjectType;

class ProjectController extends Controller {

    public function indexAction() {
        $projects = $this->getDoctrine()
                ->getManager()
                ->getRepository('ImieSkillsBundle:Project')
                ->getProjectsOrderedById();

        return $this->render('ImieSkillsBundle:Project:index.html.twig', array(
                    'projects' => $projects
        ));
    }

    public function addProjectAction(Request $req) {
        $project = new Project();
        $form = $this->createForm(new ProjectType(), $project, array(
            'action' => $this->generateUrl('imie_skills_project_add_project')
        ));

        $form->handleRequest($req);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $users = $form->get('users')->getData();
            
            foreach ($users as $user){
                $user->addJoinedProject($project);
            }
         
            $em->persist($project);
            $em->flush();

            return $this->redirect($this->generateUrl('imie_skills_project_add_project'));
        }
        return $this->render('ImieSkillsBundle:Project:addProject.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function detailProjectAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:Project');

        $project = $repo->getProjectById($id);

        return $this->render('ImieSkillsBundle:Project:detailProject.html.twig', array('project' => $project));
    }
    
    

}
