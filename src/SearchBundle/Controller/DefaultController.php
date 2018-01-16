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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * Attibut représentant tout les tags d'un produit
     *
     * @var $allTags
     */
    private $allTags;

    /**
     *      Récupère tout les tags d'un produit et les donnes à l'attribut allTags
     *
     * @return array
     *      Tags d'un produit
     */

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

    /**
     * Compare le tag voulu avec une liste de tag, et suggère une correction
     *
     * @param $tag_string
     *      Tag taper sur la barre de recherche du site
     * @return array
     *      Liste de tags
     *
     */
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
     * Associe l'URL du produit trouvé en fonction du tag taper la page  du SearchBundle
     *
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
     * Permet l'action de rechercher un produit
     *
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
     * Permet la création d'un nouveau produit dans la base de données
     *
     * @Security("has_role('ROLE_USER')")
     * @Route("/add/product", name="addProduct")
     */
    public function addProduct(Request $request) {
        $produit = new Produit();

        $produit->setPhoto(null);

        $form = $this->get('form.factory')->create(ProduitType::class, $produit, array('depots'=> $this->getDoctrine()->getRepository('SearchBundle:Depot')->findAll()));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $tagrep = $this->getDoctrine()->getRepository('SearchBundle:Tag');

            $file = $produit->getPhoto();

            // Generate a unique name for the file before saving it
            $fileName = 'photo_produit_'.$produit->getId().'_'.md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                'bundles/search/images',
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $produit->setPhoto('bundles/search/images/'.$fileName);

            $tags = $request->request->get('searchbundle_produit_tags');
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

            // ... persist the $product variable or any other work
            $em->persist($produit);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('SearchBundle:Default:formProduct.html.twig' , array(
            'title' => 'Nouveau produit',
            'form' => $form->createView(),
        ));
    }

    /**
     * Permet l'edition d'un produit déjà existant
     *
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/product/photo/{id}", name="editProduct")
     */
    public function editProductAction($id, Request $request) {
        $repository_produit = $this->getDoctrine()->getRepository('SearchBundle:Produit');
        $produit = $repository_produit->find($id);
        if($produit == null){
            return $this->redirectToRoute('home');
        }
        $produit->setPhoto(null);

        $form = $this->get('form.factory')->create(ProduitType::class, $produit, array('depots'=> $this->getDoctrine()->getRepository('SearchBundle:Depot')->findAll()));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $tagrep = $this->getDoctrine()->getRepository('SearchBundle:Tag');

            $file = $produit->getPhoto();

            // Generate a unique name for the file before saving it
            $fileName = 'photo_produit_'.$produit->getId().'_'.md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                'bundles/search/images',
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $produit->setPhoto('bundles/search/images/'.$fileName);

            $tags = $request->request->get('searchbundle_produit_tags');
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

            // ... persist the $product variable or any other work
            $em->persist($produit);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('SearchBundle:Default:formProduct.html.twig' , array(
            'title' => 'Modification de '.$produit->getName(),
            'form' => $form->createView(),
            'produit' => $produit
        ));
    }
}
