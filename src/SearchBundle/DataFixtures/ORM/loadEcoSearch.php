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



		/* DEBUT Produits */
		
		// Objets 
		$briquesDeLait = new Produit();
		$briquesDeLait->setName("Brique de lait");
		$briquesDeLait->setDepot($depotJaune);
		$bouteillesDeLait = new Produit();
		$bouteillesDeLait->setName("Bouteille de lait");
		$bouteillesDeLait->setDepot($depotJaune);
		$bouteillesEnVerre = new Produit();
		$bouteillesEnVerre->setName("Bouteille en verre");
		$bouteillesEnVerre->setDepot($depotVerre);
		$bouchons = new Produit();
		$bouchons->setName("Bouchon");
		$bouchons->setDepot($depotVerre);
		$bouteillesEnPlastique = new Produit();
		$bouteillesEnPlastique->setName("Bouteille en plastique");
		$bouteillesEnPlastique->setDepot($depotJaune);
		$televisions = new Produit();
		$televisions->setName("Television");
		$televisions->setDepot($dechetterie);
		$medicaments = new Produit();
		$medicaments->setName("Medicaments");
		$medicaments->setDepot($pharmacie);
		$seringues = new Produit();
		$seringues->setName("Seringues");
		$seringues->setDepot($pharmacie);
		$ampoules = new Produit();
		$ampoules->setName("Ampoules");
		$ampoules->setDepot($magasin);
		$piles = new Produit();
		$piles->setName("Piles");
		$piles->setDepot($magasin);
		$sachethe = new Produit();
		$sachethe->setName("Sachet de thé");
		$sachethe->setDepot($depotNoir);
		$bois = new Produit();
		$bois->setName("Bois");
		$bois->setDepot($dechetterie);
		$miroir = new Produit();
		$miroir->setName("Miroir");
		$miroir->setDepot($dechetterie);
		$livre = new Produit();
		$livre->setName("Livre");
		$livre->setDepot($depotJaune);
		$rasoir = new Produit();
		$rasoir->setName("Rasoir");
		$rasoir->setDepot($depotJaune);
		$magazine = new Produit();
		$magazine->setName("Magazine");
		$magazine->setDepot($depotJaune);
		
		
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







		
		/* DEBUT Persistance de tous les objets */
		
		
		$manager->flush();
		
		
		/* FIN Persistance de tous les objets */
		
		
		
		

	  }
	  
	}

?>