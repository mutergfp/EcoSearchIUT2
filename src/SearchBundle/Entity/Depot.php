<?php

namespace SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Depot
 *
 * @ORM\Table(name="depot")
 * @ORM\Entity(repositoryClass="SearchBundle\Repository\DepotRepository")
 */
class Depot
{
    /**
     * id d'un dépot
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * type d'un dépot
     *
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * couleur représentant le dépot
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=255)
     */
    private $couleur;

    /**
     * couleur d'un bouton associé avec la couleur représentant le dépot
     * @var string
     *
     * @ORM\Column(name="couleursec", type="string", length=255)
     */
    private $couleursec;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Depot
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     *
     * @return Depot
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set couleursec
     *
     * @param string $couleursec
     *
     * @return Depot
     */
    public function setCouleursec($couleursec)
    {
        $this->couleursec = $couleursec;

        return $this;
    }

    /**
     * Get couleursec
     *
     * @return string
     */
    public function getCouleursec()
    {
        return $this->couleursec;
    }

    /**
     * Depot constructor.
     */
    function __construct()
    {
        $this->couleur='white';
        $this->couleursec='green';
    }
}
