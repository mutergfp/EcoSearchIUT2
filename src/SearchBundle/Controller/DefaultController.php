<?php

namespace SearchBundle\Controller;

use SearchBundle\Entity\Produit;
use SearchBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    private $allTags;

    private function getAllTags()
    {
        if($this->allTags == null){
            $repository_tag = $this->getDoctrine()->getRepository('SearchBundle:Tag');
            $this->allTags = $repository_tag->findAll();
        }
        return $this->allTags;
    }

    private function rechercherTagsRessemblants($tag_string){
        $percents = array();
        $tags_found=null;
        foreach ($this->getAllTags() as $tag) {
            $percent = 0.0;
            similar_text($tag->getNom(),$tag_string,$percent);
            if($percent>70.0){
                $tags_found[]=$tag;
                $percents[$tag->getId()]=$percent;
            }
        }
        usort($tags_found,function ($a, $b) use ($percents){
            return $percents[$b->getId()] - $percents[$a->getId()];
        });
        return $tags_found;
    }

    private function rechercherLePlusRessemblant($tag_string){
        $res =  $this->rechercherTagsRessemblants($tag_string);
        if (array_key_exists(0,$res)){
            return $res[0];
        }else{
            return null;
        }
    }

    /**
     * @Route("/get/tags", name="gettags")
     */
    public function tagsAction()
    {
        $res = array();
        foreach ($this->getAllTags() as $tag)
        {
            $res[] = $tag->getNom();
        }
        $repository_prd = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $prds = $repository_prd->findAll();
        foreach ($prds as $prd)
        {
            $res[] = $prd->getName();
        }
        return new Response(json_encode($res));
    }


    /**
     * @Route("/{research}", name="search", defaults={"research" = ""})
     */
    public function searchAction($research)
    {
        if ($research=="") return $this->redirectToRoute('home');
        $tags_string = explode(" ", strtolower(urldecode($research)));

        $tags = array();

        foreach ($tags_string as $tag_string)
        {
            $tag_found = $this->rechercherLePlusRessemblant($tag_string);
            if($tag_found != null){
                $tags[] = $tag_found;
            }
        }

        $repository_produit = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $produits = $repository_produit->getByTags($tags);

        return $this->render('SearchBundle:Default:search.html.twig', array(
            "produits" => $produits,
            "recherche" => urldecode($research),
            "tags"=>$tags
        ));
    }

    /**
     * @Route("/add/product", name="addProduct")
     */
    public function addProduct() {
        $produit = new Produit();
        $form = $this->get('form.factory')->create(ProduitType::class, $produit, array('depots'=> $this->getDoctrine()->getRepository('SearchBundle:Depot')->findAll()));
        return $this->render('SearchBundle:Default:formProduct.html.twig' , array(
            'title'=> 'Nouveau produit',
           'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/product/{id}", name="editProduct")
     */
    public function editProduct($id) {
        $repository_produit = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $produit = $repository_produit->find($id);
        if($produit == null){
            return $this->redirectToRoute('home');
        }else{
            foreach ($produit->getTags() as $tag){
                $produit->setListeTags($produit->getListeTags().$tag->getNom()." ");
            }
        }
        $form = $this->get('form.factory')->create(ProduitType::class, $produit, array('depots'=> $this->getDoctrine()->getRepository('SearchBundle:Depot')->findAll()));
        return $this->render('SearchBundle:Default:formProduct.html.twig' , array(
            'title' => 'Modification de '.$produit->getName(),
            'form' => $form->createView()
        ));
    }
}
