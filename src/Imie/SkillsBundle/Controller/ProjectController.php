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

    public function addAction(Request $req) {
        $project = new Project();
        $form = $this->createForm(new ProjectType(), $project, array(
            'action' => $this->generateUrl('imie_skills_project_add')
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
            
            $req->getSession()->getFlashBag()->add('success', 'Projet créé !');

            return $this->redirect($this->generateUrl('imie_skills_project_add'));
        }
        return $this->render('ImieSkillsBundle:Project:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function detailsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:Project');

        $project = $repo->getProjectById($id);

        return $this->render('ImieSkillsBundle:Project:details.html.twig', array('project' => $project));
    }
    
    public function deleteAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();
        
        $repo = $em->getRepository('ImieSkillsBundle:Project');
        
        $project = $repo->find($id);
        
        $em->remove($project);
        $em->flush();
        
        $req->getSession()->getFlashBag()->add('success', 'Projet supprimé !');
        
        return $this->redirect($this->generateUrl('imie_skills_user_me'));
    }
}
