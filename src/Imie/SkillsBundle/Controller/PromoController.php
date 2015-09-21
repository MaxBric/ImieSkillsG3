<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Imie\SkillsBundle\Entity\Promo;
use Imie\SkillsBundle\Form\PromoType;

class PromoController extends Controller
{
    public function indexAction(){
        $promos = $this->getDoctrine()
            ->getManager()
            ->getRepository('ImieSkillsBundle:Promo')
            ->getPromosOrderedById();

        return $this->render('ImieSkillsBundle:Promo:index.html.twig', array(
            'promos' => $promos
        ));

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
                $em->persist($promo);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_promo_add'));
            }
            catch (\Doctrine\DBAL\DBALException $e){
                echo $e->getMessage();
            }
        }
        return $this->render('ImieSkillsBundle:Promo:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
