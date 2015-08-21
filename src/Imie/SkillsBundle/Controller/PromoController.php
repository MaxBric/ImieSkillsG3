<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Promo;
use Imie\SkillsBundle\Form\PromoType;

class PromoController extends Controller
{
    public function indexAction($id){

    }
    public function addAction(Request $req){

        $promo = new Promo();

        $form = $this->createForm(new PromoType(),
            $promo,
            array('action' => $this->generateUrl('imie_skills_promo_add'))
        );

        $form->handleRequest($req);
        if($form->isValid()){
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persit($promo);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_promo_add'));
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
