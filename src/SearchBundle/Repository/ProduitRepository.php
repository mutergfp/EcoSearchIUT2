<?php

namespace SearchBundle\Repository;
use SearchBundle\SearchBundle;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{


    public function getByTags($tags){
        $products = array();
        foreach ($tags as $tag){
            $res =  $this->createQueryBuilder('p')
                ->select('p')
                ->where(':tag MEMBER OF p.tags')
                ->setParameter('tag', $tag)
                ->getQuery()
                ->getResult();
            foreach ($res as $product){
                $products[] = $product;
            }
        }
        $res = array();
        $nbfound = array();
        foreach ($products as $product){
            if(!$this->chercher($product,$res)){
                $res[]=$product;
                $nbfound[$product->getId()]=1;
            }else{
                //if(!array_key_exists($product->getId(),$nbfound))$nbfound[$product->getId()]=0;
                $nbfound[$product->getId()]++;
            }
        }
        usort($res,function ($a, $b) use ($nbfound){
            return $nbfound[$b->getId()] - $nbfound[$a->getId()];
        });
        return $res;
    }

    private function chercher($produit,&$tab){
        foreach ($tab as $item){
            if($produit->getId()==$item->getId()){
                return true;
            }
        }
        return false;
    }
}
