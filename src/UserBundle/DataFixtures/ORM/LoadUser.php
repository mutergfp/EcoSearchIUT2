<?php
// src/UserBundle/DataFixtures/ORM/LoadUser.php

namespace UserBundle\DataFixtures\ORM;

use Acme\AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
 
class LoadUser extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
 
 /**
 * @var ContainerInterface
 */
 private $container;
 
 /**
 * Load data fixtures with the passed EntityManager
 * @param ObjectManager $manager
 */
 public function load(ObjectManager $manager)
 {
   $userManager = $this->container->get('fos_user.user_manager');
 
   $user = $userManager->createUser();
   $user->setUsername('utilisateur');
   $user->setEmail('utilisateur@ecosearch.fr');
   $user->setPlainPassword('utilisateur');
   $user->setEnabled(true);
   $user->addRole('ROLE_USER');
   $this->addReference('user-admin', $user);
   $userManager->updateUser($user);
 }
 
 /**
 * Sets the container.
 * @param ContainerInterface|null $container A ContainerInterface instance or null
 */
 public function setContainer(ContainerInterface $container = null)
 {
   $this->container = $container;
 }
 
  /**
 * Get the order of this fixture
 * @return integer
 */
 public function getOrder()
 {
   return 2;
 }
 
}