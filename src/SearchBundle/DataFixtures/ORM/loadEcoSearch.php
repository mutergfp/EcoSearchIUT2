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
          $depotVerre->setCouleur("teal darken-3");
          $depotJaune = new Depot();
          $depotJaune->setType("Poubelle jaune");
          $depotJaune->setCouleur("yellow darken-1");
          $depotNoir = new Depot();
          $depotNoir->setType("Poubelle pour ordures ménagères");
          $depotNoir->setCouleur("black");
          $dechetterie = new Depot();
          $dechetterie->setType("Dechetterie");
          $dechetterie->setCouleur("brown");
          $pharmacie = new Depot();
          $pharmacie->setType("Pharmacie");
          $pharmacie->setCouleur("green accent-1");
          $magasin = new Depot();
          $magasin->setType("Magasin");
          $magasin->setCouleur("red lighten-1");


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
          $tagMedicaments->setNom("medicament");
          $tagSeringues = new Tag();
          $tagSeringues->setNom("seringue");
          $tagAmpoules = new Tag();
          $tagAmpoules->setNom("ampoule");
          $tagPiles = new Tag();
          $tagPiles->setNom("pile");
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





		/* DEBUT Produits */
		
		// Objets 
		$briquesDeLait = new Produit();
		$briquesDeLait->setName("Brique de lait");
		$briquesDeLait->setDepot($depotJaune);
		$briquesDeLait->addTag($tagBrique);
		$briquesDeLait->addTag($tagLait);
		$briquesDeLait->setPhoto("bundles/search/images/BriqueLait.jpg");

		$bouteillesDeLait = new Produit();
		$bouteillesDeLait->setName("Bouteille de lait");
		$bouteillesDeLait->setDepot($depotJaune);
		$bouteillesDeLait->addTag($tagLait);
		$bouteillesDeLait->addTag($tagBouteille);
		$bouteillesDeLait->setPhoto("bundles/search/images/BouteilleLait.jpg");

		$bouteillesEnVerre = new Produit();
		$bouteillesEnVerre->setName("Bouteille en verre");
		$bouteillesEnVerre->setDepot($depotVerre);
		$bouteillesEnVerre->addTag($tagVerre);
		$bouteillesEnVerre->addTag($tagBouteille);
		$bouteillesEnVerre->setPhoto("bundles/search/images/BouteilleVerre.jpg");

		$bouchons = new Produit();
		$bouchons->setName("Bouchon");
		$bouchons->setDepot($depotNoir);
		$bouchons->addTag($tagBouchons);
		$bouchons->setPhoto("bundles/search/images/Bouchon.jpg");

		$bouteillesEnPlastique = new Produit();
		$bouteillesEnPlastique->setName("Bouteille en plastique");
		$bouteillesEnPlastique->setDepot($depotJaune);
		$bouteillesEnPlastique->addTag($tagBouteille);
		$bouteillesEnPlastique->addTag($tagPlastique);
		$bouteillesEnPlastique->setPhoto("bundles/search/images/BouteillePlastique.jpg");

		$televisions = new Produit();
		$televisions->setName("Television");
		$televisions->setDepot($dechetterie);
		$televisions->addTag($tagTelevisions);
		$televisions->setPhoto("bundles/search/images/Television.jpg");

		$medicaments = new Produit();
		$medicaments->setName("Medicament");
		$medicaments->setDepot($pharmacie);
		$medicaments->addTag($tagMedicaments);
		$medicaments->setPhoto("bundles/search/images/Medicament.jpg");

		$seringues = new Produit();
		$seringues->setName("Seringue");
		$seringues->setDepot($pharmacie);
		$seringues->addTag($tagSeringues);
		$seringues->setPhoto("bundles/search/images/Seringues.jpg");

		$ampoules = new Produit();
		$ampoules->setName("Ampoule");
		$ampoules->setDepot($magasin);
		$ampoules->addTag($tagAmpoules);
		$ampoules->setPhoto("bundles/search/images/Ampoule.jpg");

		$piles = new Produit();
		$piles->setName("Pile");
		$piles->setDepot($magasin);
		$piles->addTag($tagPiles);
		$piles->setPhoto("bundles/search/images/Piles.jpg");

		$sachethe = new Produit();
		$sachethe->setName("Sachet de thé");
		$sachethe->setDepot($depotNoir);
		$sachethe->addTag($tagThe);
		$sachethe->setPhoto("bundles/search/images/SachetThe.jpg");

		$bois = new Produit();
		$bois->setName("Bois");
		$bois->setDepot($dechetterie);
		$bois->addTag($tagBois);
		$bois->setPhoto("bundles/search/images/Bois.jpg");

		$miroir = new Produit();
		$miroir->setName("Miroir");
		$miroir->setDepot($dechetterie);
		$miroir->addTag($tagMiroir);
		$miroir->setPhoto("bundles/search/images/Miroir.jpg");

		$livre = new Produit();
		$livre->setName("Livre");
		$livre->setDepot($depotJaune);
		$livre->addTag($tagLivre);
		$livre->setPhoto("bundles/search/images/Livre.jpeg");

		$rasoir = new Produit();
		$rasoir->setName("Rasoir");
		$rasoir->setDepot($depotJaune);
		$rasoir->addTag($tagRasoir);
		$rasoir->setPhoto("bundles/search/images/Rasoir.jpg");

		$magazine = new Produit();
		$magazine->setName("Magazine");
		$magazine->setDepot($depotJaune);
		$magazine->addTag($tagMagazine);
		$magazine->setPhoto("bundles/search/images/Magazine.jpg");
		
		
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

		
		/* DEBUT Persistance de tous les objets */
		
		
		$manager->flush();
		
		
		/* FIN Persistance de tous les objets */
		
		
		
		

	  }
	  
	}

?>