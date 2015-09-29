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
                $promo->setPromoFullName();
                $em->persist($promo);
                $em->flush();
                return $this->redirect($this->generateUrl('imie_skills_promo_index'));
            }
            catch (\Doctrine\DBAL\DBALException $e){
                echo $e->getMessage();
            }
        }
        return $this->render('ImieSkillsBundle:Promo:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function detailAction(Request $req, $id){

        $users = $this->getDoctrine()
            ->getRepository('ImieSkillsBundle:User')
            ->getUsersByPromoId($id);

        return $this->render('ImieSkillsBundle:Promo:detail.html.twig',array(
            'users'=>$users
        ));
    }

    public function modifyAction(Request $req, $id) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ImieSkillsBundle:Promo');
        $promoToModify = $repo->findOneById($id);
        $form = $this->createForm(new PromoType(), $promoToModify, array(
            'action' => $this->generateUrl('imie_skills_promo_modify', array(
                'id' => $id
            ))
        ));

        $form->handleRequest($req);

        if ($form->isValid()) {
            try {
                $em->flush();
                $req->getSession()->getFlashBag()->add('success', 'promo modifié');
                return $this->redirect($this->generateUrl('imie_skills_promo_index'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                    . PHP_EOL . $e->getMessage());
            }
        }

        return $this->render('ImieSkillsBundle:promo:modify.html.twig', array(
            'form' => $form->createView(),
            'id' => $id
        ));
    }

    public function deleteAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('ImieSkillsBundle:Promo');

        $promo = $repo->findOneById($id);
        try {
            $em->remove($promo);
            $em->flush();

            $req->getSession()->getFlashBag()->add('success', 'Promo supprimé');
        } catch (\Doctrine\DBAL\DBALException $e) {
            $req->getSession()->getFlashBag()->add('danger', 'Erreur lors de la suppression :'
                . PHP_EOL . $e->getMessage());
        }

        return $this->redirect($this->generateUrl('imie_skills_promo_index'));
    }

}
