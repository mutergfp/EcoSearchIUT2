<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/" ,name="home")
     */
    public function indexAction()
    {
        return $this->render('CoreBundle:Default:index.html.twig');
    }

    /**
     * @Route("/participate", name="participate")
     */
    public function participateAction()
    {
        return $this->render('CoreBundle:Default:participateEx.html.twig');
    }
}
