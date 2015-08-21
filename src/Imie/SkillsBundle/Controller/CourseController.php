<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Course;
use Imie\SkillsBundle\Form\CourseType;

class CourseController extends Controller
{
    public function indexAction($id){

    }
    public function addCourseAction(Request $req){

        $course = new Course();

        $form = $this->createForm(new CourseType(),
            $course,
            array('action' => $this->generateUrl('imie_skills_course_add'))
        );

        $form->handleRequest($req);
        if($form->isValid()){
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persit($course);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_course_add'));
            }
            catch (\Doctrine\DBAL\DBALException $e){
                echo $e->getMessage();
            }
        }
        return $this->render('ImieSkillsBundle:Formation:addFormation.html.twig', array(
            'form' => $form->createView()
        ));
    }
}