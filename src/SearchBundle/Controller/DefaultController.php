<?php

namespace SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/{research}")
     */
    public function searchAction($research)
    {
        $tags_string = explode('_',$research);
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
        return new Response(var_dump($tags_string));
    }
}
