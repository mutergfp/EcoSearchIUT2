<?php

namespace SearchBundle\Controller;

use SearchBundle\Entity\Produit;
use SearchBundle\Entity\Tag;
use SearchBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
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
        $tags_found = array();
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
     * @Route("/get/tags/product/{id}", name="gettagsproduct")
     */
    public function productTagsAction($id){
        $repository_produit = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $produit = $repository_produit->find($id);
        $res = array();
        foreach ($produit->getTags() as $tag){
            $res[]=$tag->getNom();
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
    public function addProduct(Request $request) {
        $produit = new Produit();
        $form = $this->get('form.factory')->create(ProduitType::class, $produit, array('depots'=> $this->getDoctrine()->getRepository('SearchBundle:Depot')->findAll()));

        if ($request->isMethod('POST')) {

            $depotrep = $this->getDoctrine()->getRepository('SearchBundle:Depot');
            $tagrep = $this->getDoctrine()->getRepository('SearchBundle:Tag');
            $em = $this->getDoctrine()->getManager();

            $name = $request->request->get('name');
            $photo = $request->request->get('photo');
            $depot = $request->request->get('depot');
            $tags = $request->request->get('tags');

            $produit->setName($name);
            $produit->setPhoto($photo);
            $produit->setDepot($this->getDoctrine()->getRepository('SearchBundle:Depot')->findOneByType($depot));
            $produit->resetTags();
            foreach ($tags as $tag){
                $tagobj = $tagrep->findOneByNom($tag);
                if($tagobj == null){
                    $tagobj = new Tag();
                    $tagobj->setNom($tag);
                    $em->persist($tagobj);
                }
                $produit->addTag($tagobj);
            }
            $em->persist($produit);
            $em->flush();
            return new Response($this->generateUrl('home'));
        }

        return $this->render('SearchBundle:Default:formProduct.html.twig' , array(
            'title'=> 'Nouveau produit',
           'form' => $form->createView(),
            'produit' => $produit
        ));
    }

    /**
     * @Route("/edit/product/{id}", name="editProduct")
     */
    public function editProduct($id, Request $request) {
        $repository_produit = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $produit = $repository_produit->find($id);
        $produit->setPhoto(null);
        if($produit == null){
            return $this->redirectToRoute('home');
        }
        $form = $this->get('form.factory')->create(ProduitType::class, $produit, array('depots'=> $this->getDoctrine()->getRepository('SearchBundle:Depot')->findAll()));

        if ($request->isMethod('POST')) {

            $depotrep = $this->getDoctrine()->getRepository('SearchBundle:Depot');
            $tagrep = $this->getDoctrine()->getRepository('SearchBundle:Tag');
            $em = $this->getDoctrine()->getManager();

            $name = $request->request->get('name');
            $depot = $request->request->get('depot');
            $tags = $request->request->get('tags');

            $produit->setName($name);
            $produit->setDepot($this->getDoctrine()->getRepository('SearchBundle:Depot')->findOneByType($depot));
            $produit->resetTags();
            foreach ($tags as $tag){
                $tagobj = $tagrep->findOneByNom($tag);
                if($tagobj == null){
                    $tagobj = new Tag();
                    $tagobj->setNom($tag);
                    $em->persist($tagobj);
                }
                $produit->addTag($tagobj);
            }
            $em->flush();
            return new Response($this->generateUrl('home'));
        }

        return $this->render('SearchBundle:Default:formProduct.html.twig' , array(
            'title' => 'Modification de '.$produit->getName(),
            'form' => $form->createView(),
            'produit' => $produit
        ));
    }

    /**
     * @Route("/edit/product/photo/{id}", name="editProductPhoto")
     */
    public function editProductPhoto($id, Request $request)
    {
        $repository_produit = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $produit = $repository_produit->find($id);
        if($request->isMethod('POST')){
            $photo = $request->files->get('photo');
            if($photo != null){
                $nom = 'bundles/search/images/photo_produit_'.$produit->getId().'_'.uniqid(rand(), true);
                move_uploaded_file($photo,$nom);
                $produit->setPhoto($nom);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }
            //return $this->redirectToRoute('home');
        }
    }
}
