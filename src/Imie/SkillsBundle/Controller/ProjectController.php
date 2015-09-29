<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Project;
use Imie\SkillsBundle\Form\ProjectType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProjectController extends Controller {

  public function indexAction() {
    if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
      throw new AccessDeniedException();
    }
    $projects = $this->getDoctrine()
    ->getManager()
    ->getRepository('ImieSkillsBundle:Project')
    ->getProjectsOrderedById();

    return $this->render('ImieSkillsBundle:Project:index.html.twig', array(
      'projects' => $projects
    ));
  }

  public function addAction(Request $req) {
    if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
      throw new AccessDeniedException();
    }
    $project = new Project();
    $form = $this->createForm(new ProjectType(), $project, array(
      'action' => $this->generateUrl('imie_skills_project_add')));
      $form->handleRequest($req);
      if ($form->isValid()) {
        try {
          $em = $this->getDoctrine()->getManager();
          $users = $form->get('users')->getData();
          $currentUser = $this->get('security.token_storage')->getToken()->getUser();
          $project->setCreator($currentUser);
          foreach ($users as $user) {
            $user->addJoinedProject($project);
          }
          if ($project->getImage()) {
            $project->getImage()->setImageAlt($project->getProjectName());
          }
          $em->persist($project);
          $em->flush();
          $req->getSession()->getFlashBag()->add('success', 'Projet ajouté');
          return $this->redirect($this->generateUrl('imie_skills_project_details', array(
            'id' => $id
          )));
        } catch (\Doctrine\DBAL\DBALException $e) {
          $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'ajout :'
          . PHP_EOL . $e->getMessage());
        }
      }
      return $this->render('ImieSkillsBundle:Project:add.html.twig', array(
        'form' => $form->createView()
      ));
    }

    public function detailsAction($id) {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }
      $em = $this->getDoctrine()->getManager();
      $repo = $em->getRepository('ImieSkillsBundle:Project');
      $project = $repo->getProjectById($id);
      return $this->render('ImieSkillsBundle:Project:details.html.twig', array('project' => $project));
    }

    public function modifyAction(Request $req, $id) {
      $em = $this->getDoctrine()->getManager();
      $repo = $em->getRepository('ImieSkillsBundle:Project');
      $projectToModify = $repo->findOneById($id);
      $creatorId = $projectToModify->getCreator()->getId();
      if ($creatorId != $this->get('security.token_storage')->getToken()->getUser()->getId()) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          throw new AccessDeniedException();
        }
      }
      $form = $this->createForm(new ProjectType(), $projectToModify, array(
        'action' => $this->generateUrl('imie_skills_project_modify', array(
          'id' => $id
        ))
      ));
      $form->handleRequest($req);
      if ($form->isValid()) {
        try {
          $users = $form->get('users')->getData();
          foreach ($users as $user) {
            $projs = $user->getJoinedProjects();
            foreach ($projs as $proj) {
              if ($proj == $projectToModify) {
                $user->removeJoinedProject($projectToModify);
              }
            }
            $user->addJoinedProject($projectToModify);
          }
          if ($projectToModify->getImage()) {
            $projectToModify->getImage()->setImageAlt($projectToModify->getProjectName());
          }
          $em->flush();
          $req->getSession()->getFlashBag()->add('success', 'Projet modifié');
        } catch (\Exception $e) {
          $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la modification :'
          . $e->getMessage());
        }
      }
      return $this->render('ImieSkillsBundle:Project:modify.html.twig', array(
        'form' => $form->createView(),
        'id' => $id
      ));
    }

    public function deleteAction(Request $req, $id) {
      $em = $this->getDoctrine()->getManager();
      $repo = $em->getRepository('ImieSkillsBundle:Project');
      $project = $repo->findOneById($id);
      $creatorId = $project->getCreator()->getId();
      if ($creatorId != $this->get('security.token_storage')->getToken()->getUser()->getId()) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          throw new AccessDeniedException();
        }
      }
      try {
        $em->remove($project);
        $em->flush();
        $req->getSession()->getFlashBag()->add('success', 'Projet supprimé');
        return $this->redirect($this->generateUrl('imie_skills_project_index'));
      } catch (\Doctrine\DBAL\DBALException $e) {
        $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
        . PHP_EOL . $e->getMessage());
      }
      return $this->redirect($this->generateUrl('imie_skills_project_index'));
    }

    public function deleteUserAction(Request $req, $id1, $id2) {
      $em = $this->getDoctrine()->getManager();
      $projectRepo = $em->getRepository('ImieSkillsBundle:Project');
      $userRepo = $em->getRepository('ImieSkillsBundle:User');
      $project = $projectRepo->findOneById($id1);
      $user = $userRepo->getUserById($id2);
      $creatorId = $project->getCreator()->getId();
      if ($creatorId != $this->get('security.token_storage')->getToken()->getUser()->getId()) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
          throw new AccessDeniedException();
        }
      }
      try {
        $user->removeJoinedProject($project);
        $em->flush();
        $req->getSession()->getFlashBag()->add('success', 'Utilisateur retiré');
        return $this->redirect($this->generateUrl('imie_skills_project_details', array(
          'id' => $id1
        )));
      } catch (\Doctrine\DBAL\DBALException $e) {
        $req->getSession()->getFlashBag()->add('danger', 'Erreur lors du retrait de l\'utilisateur :'
        . PHP_EOL . $e->getMessage());
      }
      return $this->redirect($this->generateUrl('imie_skills_project_details', array(
        'id' => $id1
      )));
    }
  }
