<?php

namespace Imie\SkillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PanelController extends Controller
{
    public function indexAction()
    {
        return $this->render('ImieSkillsBundle:Panel:index.html.twig');
    }
}
