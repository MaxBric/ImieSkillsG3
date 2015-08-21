<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\School;
use Imie\SkillsBundle\Form\SchoolType;

class SchoolController extends Controller
{
    public function indexAction($id){

    }
    public function addSchoolAction(Request $req){

        $school = new School();

        $form = $this->createForm(new SchoolType(),
            $school,
            array('action' => $this->generateUrl('imie_skills_school_add'))
        );

        $form->handleRequest($req);
        if($form->isValid()){
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persit($school);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_school_add'));
            }
            catch (\Doctrine\DBAL\DBALException $e){
                echo $e->getMessage();
            }
        }
        return $this->render('ImieSkillsBundle:Formation:add.html.twig', array(
            'form' => $form->createView()
        ));
    }
}