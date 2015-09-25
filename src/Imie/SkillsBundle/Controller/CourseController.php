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
//        $schools = $this->getDoctrine()
//            ->getManager()
//            ->getRepository('ImieSkillsBundle:Course')
//            ->getSchoolsOrderedById();

        return $this->render('ImieSkillsBundle:Course:index.html.twig', array(
            'courses' => $courses,
//            'schools' => $schools
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
                $em->persist($course);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_course_add'));
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
                $req->getSession()->getFlashBag()->add('success', 'course modifi�');
                return $this->redirect($this->generateUrl('imie_skills_course_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:course:update.html.twig', array(
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

            $req->getSession()->getFlashBag()->add('success', 'Course supprim�');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                . PHP_EOL . $e->getMessage());
        }

        return $this->redirect($this->generateUrl('imie_skills_course_index'));
    }
}
