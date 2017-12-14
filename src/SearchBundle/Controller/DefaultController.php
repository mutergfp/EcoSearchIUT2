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
        if ($research=="") return $this->redirectToRoute('home');
        $tags_string = explode(" ", strtolower(urldecode($research)));
        $repository_tag = $this->getDoctrine()->getRepository('SearchBundle:Tag');
        $tags = array();
        $tags_found = $repository_tag->findAll();
        foreach ($tags_string as $tag_string)
        {
            $percent_max=0.0;
            $tag_found=null;
            foreach ($tags_found as $tag) {
                $percent = 0.0;
                similar_text($tag->getNom(),$tag_string,$percent);
                if($percent>$percent_max && $percent>70.0){
                    $tag_found=$tag;
                    $percent_max=$percent;
                }
            }
            if($tag_found != null){
                $tags[] = $tag_found;
                //$tag_found->setNom($tag_found->getNom().' ('.round($percent_max).'%)');
            }
        }

        $repository_produit = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $produits = $repository_produit->getByTags($tags);

        return $this->render('SearchBundle:Default:search.html.twig', array(
            "produits" => $produits,
            "recherche" => urldecode($research),
            "tags"=>$tags
        ));
        //return new Response(var_dump($produits));
    }
}
