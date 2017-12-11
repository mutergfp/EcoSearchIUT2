<?php

namespace SearchBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SearchBundle\Entity\Depot;
use SearchBundle\Entity\Produit;
use SearchBundle\Entity\Tag;

class loadEcoSearch implements FixtureInterface
	{

	  public function load(ObjectManager $manager)

	  {

		/* DEBUT Produits */
		
		// Objets 
		$briquesDeLait = new Produit();
		$briquesDeLait->setName("Brique de lait");
		$bouteillesDeLait = new Produit();
		$bouteillesDeLait->setName("Bouteille de lait");
		$bouteillesEnVerre = new Produit();
		$bouteillesEnVerre->setName("Bouteille en verre");
		$bouchons = new Produit();
		$bouchons->setName("Bouchon");
		$bouteillesEnPlastique = new Produit();
		$bouteillesEnPlastique->setName("Bouteille en plastique");
		$televisions = new Produit();
		$televisions->setName("Television");
		$medicaments = new Produit();
		$medicaments->setName("Medicaments");
		$seringues = new Produit();
		$seringues->setName("Seringues");
		$ampoules = new Produit();
		$ampoules->setName("Ampoules");
		$piles = new Produit();
		$piles->setName("Piles");
		$sachethe = new Produit();
		$sachethe->setName("Sachet de thé");
		$bois = new Produit();
		$bois->setName("Bois");
		$miroir = new Produit();
		$miroir->setName("Miroir");
		$livre = new Produit();
		$livre->setName("Livre");
		$rasoir = new Produit();
		$rasoir->setName("Rasoir");
		$magazine = new Produit();
		$magazine->setName("Magazine");
		
		
		//Persistance
		$manager->persist($briquesDeLait);
		$manager->persist($bouteillesDeLait);
		$manager->persist($bouteillesEnVerre);
		$manager->persist($bouchons);
		$manager->persist($bouteillesEnPlastique);
		$manager->persist($televisions);
		$manager->persist($medicaments);
		$manager->persist($seringues);
		$manager->persist($ampoules);
		$manager->persist($piles);
		$manager->persist($sachethe);
		$manager->persist($bois);
		$manager->persist($miroir);
		$manager->persist($livre);
		$manager->persist($rasoir);
		$manager->persist($magazine);

		/* FIN Produits */
		
		
		/* DEBUT Dépots */

		//objet
		$depotVerre = new Depot();
		$depotVerre->setType("Poubelle pour verre");
		$depotJaune = new Depot();
		$depotJaune->setType("Poubelle jaune");
		$depotNoir = new Depot();
		$depotNoir->setType("Poubelle pour ordures ménagères");
		$dechetterie = new Depot();
		$dechetterie->setType("Dechetterie");
		$pharmacie = new Depot();
		$pharmacie->setType("Pharmacie");
		$magasin = new Depot();
		$magasin->setType("Magasin");
		
		
		//Persistance
		$manager->persist($depotVerre);
		$manager->persist($depotJaune);
		$manager->persist($depotNoir);
		$manager->persist($dechetterie);
		$manager->persist($pharmacie);
		$manager->persist($magasin);
		
		/* FIN Dépots */

		/* DEBUT tag */
          $tagBouteille = new Tag();
          $tagBouteille->setNom("bouteille");
          $tagLait = new Tag();
          $tagLait->setNom("lait");
          $tagVerre = new Tag();
          $tagVerre->setNom("verre");
          $tagBrique = new Tag();
          $tagBrique->setNom("brique");
          $tagBouchons = new Tag();
          $tagBouchons->setNom("bouchon");
          $tagPlastique = new Tag();
          $tagPlastique->setNom("plastique");
          $tagTelevisions = new Tag();
          $tagTelevisions->setNom("television");
          $tagMedicaments = new Tag();
          $tagMedicaments->setNom("medicaments");
          $tagSeringues = new Tag();
          $tagSeringues->setNom("seringues");
          $tagAmpoules = new Tag();
          $tagAmpoules->setNom("ampoules");
          $tagPiles = new Tag();
          $tagPiles->setNom("piles");
          $tagThe = new Tag();
          $tagThe->setNom("the");
          $tagBois = new Tag();
          $tagBois->setNom("bois");
          $tagMiroir = new Tag();
          $tagMiroir->setNom("miroir");
          $tagLivre = new Tag();
          $tagLivre->setNom("livre");
          $tagRasoir = new Tag();
          $tagRasoir->setNom("rasoir");
          $tagMagazine = new Tag();
          $tagMagazine->setNom("magazine");

          /* FIN tag */

          /* AJOUT DES TAG */
          $briquesDeLait->addTag($tagBrique);
          $briquesDeLait->addTag($tagLait);
          $bouteillesEnVerre->addTag($tagVerre);
          $bouchons->addTag($tagBouchons);
          $bouteillesEnPlastique->addTag($tagBouteille);
          $bouteillesEnPlastique->addTag($tagPlastique);
          $televisions->addTag($tagTelevisions);
          $medicaments->addTag($tagMedicaments);
          $seringues->addTag($tagSeringues);
          $ampoules->addTag($tagAmpoules);
          $piles->addTag($tagPiles);
          $sachethe->addTag($tagThe);
          $bois->addTag($tagBois);
          $miroir->addTag($tagMiroir);
          $livre->addTag($tagLivre);
          $rasoir->addTag($tagRasoir);
          $magazine->addTag($tagMagazine);






		$briquesDeLait->setDepot($depotJaune);
		
		/* DEBUT Persistance de tous les objets */
		
		
		$manager->flush();
		
		
		/* FIN Persistance de tous les objets */
		
		
		
		

	  }
	  
	}

?>