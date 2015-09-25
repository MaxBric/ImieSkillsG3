<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\School;
use Imie\SkillsBundle\Form\SchoolType;
use Imie\SkillsBundle\Entity\Course;
//use Imie\SkillsBundle\Entity\SchoolRepository;


class SchoolController extends Controller
{
    public function indexAction(){
        $schools = $this->getDoctrine()
            ->getManager()
            ->getRepository('ImieSkillsBundle:School')
            ->getSchoolsOrderedById();

        return $this->render('ImieSkillsBundle:School:index.html.twig', array(
            'school' => $schools
        ));
    }

    public function addAction(Request $req){

        $school = new School();

        $form = $this->createForm(new SchoolType(),
            $school,
            array('action' => $this->generateUrl('imie_skills_school_add'))
        );


        $form->handleRequest($req);
        if($form->isValid()){
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($school);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_school_add'));
            }
            catch (\Doctrine\DBAL\DBALException $e){
                echo $e->getMessage();
            }
        }

        return $this->render('ImieSkillsBundle:School:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function modifyAction(Request $req, $id) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:School');
        $schoolToModify = $repo->findOneById($id);
        $form = $this->createForm(new SchoolType(), $schoolToModify, array(
            'action' => $this->generateUrl('imie_skills_school_modify', array(
                'id' => $id
            ))
        ));

        $form->handleRequest($req);

        if ($form->isValid()) {
            try {
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'school modifié');
                return $this->redirect($this->generateUrl('imie_skills_school_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:school:update.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }

    public function deleteAction(Request $req, $id) {

        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('ImieSkillsBundle:School');

        $school = $repo->findOneById($id);
        try {

            $em->remove($school);
            $em->flush();

            $req->getSession()->getFlashBag()->add('success', 'School supprimé');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                . PHP_EOL . $e->getMessage());
        }

        return $this->redirect($this->generateUrl('imie_skills_school_index'));
    }
}
