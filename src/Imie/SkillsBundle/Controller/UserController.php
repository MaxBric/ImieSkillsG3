<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction($id)
    {
        return $this->render('ImieSkillsBundle:Profile:myProfile.html.twig', array('id' => $id));
    }
}
