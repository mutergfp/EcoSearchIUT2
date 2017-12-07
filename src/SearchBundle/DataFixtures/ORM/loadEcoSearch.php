<?php 


	class loadEcoSearch implements FixtureInterface
	{

	  public function load(ObjectManager $manager)

	  {

		/* DEBUT Produits */
		
		// Objets 
		$briquesDeLait = new Produit("Brique de lait");
		$bouteillesDeLait = new Produit("Bouteille de lait");
		$bouteillesEnVerre = new Produit("Bouteille en verre");
		$bouchons = new Produit("Bouchon");
		$bouteillesEnPlastique = new Produit("Bouteille en plastique");
		$televisions = new Produit("Television");
		$medicaments = new Produit("Medicaments");
		$seringues = new Produit("Seringues");
		$ampoules = new Produit("Ampoules");
		$piles = new Produit("Piles");
		
		
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
		
		
		/* FIN Produits */
		
		
		/* DEBUT Dépots */
		
		// Objets
		$depotVerre = new Depot("Poubelle pour verre");
		$depotJaune = new Depot("Poubelle jaune");
		$depotNoir = new Depot("Poubelle pour ordures ménagères");
		$dechetterie = new Depot("Dechetterie");
		$pharmacie = new Depot("Pharmacie");
		$magasin = new Depot("Magasin");
		
		
		// Persistance
		$manager->persist($depotVerre);
		$manager->persist($depotJaune);
		$manager->persist($depotNoir);
		$manager->persist($dechetterie);
		$manager->persist($pharmacie);
		$manager->persist($magasin);

		
		/* FIN Dépots */
		
		
		/* DEBUT Correspondances */
		
		// Objets
		$corr_briquesDeLait = new Correspondance($briquesDeLait, $depotJaune);
		$corr_bouteillesDeLait = new Correspondance($bouteillesDeLait, $depotJaune);
		$corr_bouteillesEnVerre = new Correspondance($bouteillesEnVerre, $depotVerre);
		$corr_bouchons = new Correspondance($bouchons, $depotJaune);
		$corr_bouteillesEnPlastique = new Correspondance($bouteillesEnPlastique, $depotJaune);
		$corr_televisions = new Correspondance($televisions, $dechetterie);
		$corr_medicaments = new Correspondance($medicaments, $pharmacie);
		$corr_seringues = new Correspondance($seringues, $pharmacie);
		$corr_ampoules = new Correspondance($ampoules, $magasin);
		$corr_piles = new Correspondance($piles, $magasin);
		
		
		// Persistance
		$manager->persist($corr_briquesDeLait);
		$manager->persist($corr_bouteillesDeLait);
		$manager->persist($corr_bouteillesEnVerre);
		$manager->persist($corr_bouchons);
		$manager->persist($corr_bouteillesEnPlastique);
		$manager->persist($corr_televisions);
		$manager->persist($corr_medicaments);
		$manager->persist($corr_seringues);
		$manager->persist($corr_ampoules);
		$manager->persist($corr_piles);
		
		
		/* FIN Correspondances */
		
		
		/* DEBUT Persistance de tous les objets */
		
		
		$manager->flush();
		
		
		/* FIN Persistance de tous les objets */
		
		
		
		

	  }
	  
	}

?>