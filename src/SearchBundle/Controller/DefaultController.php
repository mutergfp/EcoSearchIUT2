<?php

namespace SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/{research}", name="search", defaults={"research" = ""})
     */
    public function searchAction($research)
    {
        $tags_string = explode(" ", urldecode($research));
        $repository_tag = $this->getDoctrine()->getRepository('SearchBundle:Tag');
        $tags = array();
        foreach ($tags_string as $tag_string)
        {
            $tag = $repository_tag->findOneBy(array(
                'nom' => $tag_string
            ));
            if($tag != null){
                $tags[] = $tag;
            }
        }
        $repository_produit = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $produits = $repository_produit->getByTags($tags);

        return $this->render('SearchBundle:Default:search.html.twig', array(
            "produits" => $produits,
            "recherche" => urldecode($research)
        ));
        //return new Response(var_dump($produits));
    }
}
