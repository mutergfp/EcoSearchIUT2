<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * Associe l'URL avec la page index.html.twig du CoreBundle
     *
     * @Route("/" ,name="home")
     */
    public function indexAction()
    {
        return $this->render('CoreBundle:Default:index.html.twig');
    }

    /**
     * Associe l'URL avec la page participateEx.html.twig du CoreBundle
     *
     * @Route("/participate", name="participate")
     */
    public function participateAction()
    {
        return $this->render('CoreBundle:Default:participateEx.html.twig');
    }
}
