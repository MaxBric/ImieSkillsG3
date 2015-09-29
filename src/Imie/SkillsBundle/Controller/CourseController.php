<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Course;
use Imie\SkillsBundle\Form\CourseType;

class CourseController extends Controller
{
    public function indexAction(){
        $courses = $this->getDoctrine()
            ->getManager()
            ->getRepository('ImieSkillsBundle:Course')
            ->getCoursesOrderedById();

        return $this->render('ImieSkillsBundle:Course:index.html.twig', array(
            'courses' => $courses,
        ));

    }

    public function detailAction(Request $req, $id){
        $course = $this->getDoctrine()
            ->getRepository('ImieSkillsBundle:Course')
            ->getCourseById($id);

        return $this->render('ImieSkillsBundle:Course:detail.html.twig',array(
            'course'=>$course
        ));
    }

    public function addAction(Request $req){

        $course = new Course();

        $form = $this->createForm(new CourseType(),
            $course,
            array('action' => $this->generateUrl('imie_skills_course_add'))
        );

        $form->handleRequest($req);
        if($form->isValid()){
            try{
                $em = $this->getDoctrine()->getManager();
                $course->setCourseFullName();
                $em->persist($course);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_course_index'));
            }
            catch (\Doctrine\DBAL\DBALException $e){
                echo $e->getMessage();
            }
        }

        return $this->render('ImieSkillsBundle:Course:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function modifyAction(Request $req, $id) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:Course');
        $courseToModify = $repo->findOneById($id);
        $form = $this->createForm(new CourseType(), $courseToModify, array(
            'action' => $this->generateUrl('imie_skills_course_modify', array(
                'id' => $id
            ))
        ));

        $form->handleRequest($req);

        if ($form->isValid()) {
            try {
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'course modifié');
                return $this->redirect($this->generateUrl('imie_skills_course_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:course:modify.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }

    public function deleteAction(Request $req, $id) {

        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('ImieSkillsBundle:Course');

        $course = $repo->findOneById($id);
        try {
            $em->remove($course);
            $em->flush();

            $req->getSession()->getFlashBag()->add('success', 'Course supprimé');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                . PHP_EOL . $e->getMessage());
        }

        return $this->redirect($this->generateUrl('imie_skills_course_index'));
    }
}
