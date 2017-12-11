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
        $i2=0;
        $tabReturn = 0;
        $repository =  $this->getDoctrine()->getRepository(SearchBundle::Produit);
        for($i = 0; $i< count($tags); $i++) {
            $products = $repository->findBy([
                'tags' => $tags
            ]);
            for (;$i2<count($products); $i2++) {
                $tabReturn[$i2] = var_dump($products[$i2]);
                }
            }
            return $tabReturn;
        }

    }
