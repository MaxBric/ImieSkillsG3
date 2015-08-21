<?php 

namespace Imie\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller {
    public function loginAction() {
        $helper = $this->get('security.authentication_utils');

        return $this->render('ImieTestBundle:Security:login.html.twig', array(
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ));
    }
}