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
        $tagsrepo = $this->getDoctrine()->getRepository("SearchBundle:Tag");
        $tags = $tagsrepo->findAll();

        return $this->render('CoreBundle:Default:index.html.twig', array(
            "allTags" => $tags
        ));
    }
}
