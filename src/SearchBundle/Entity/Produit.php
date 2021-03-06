<?php

namespace SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="SearchBundle\Repository\ProduitRepository")
 */
class Produit
{

    /**
     * id d'un produit
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * id du dépot d'un produit
     *
     * @ORM\ManyToOne(targetEntity="SearchBundle\Entity\Depot")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depot;

    /**
     * tags du produit
     *
     * @ORM\ManyToMany(targetEntity="SearchBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * nom d'un produit
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * photo d'un produit
     *
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=1000, nullable=true)
     */
    private $photo;


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
     * Set name
     *
     * @param string $name
     *
     * @return Produit
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Produit
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photo = "bundles/core/images/EcoSearch.png";
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->listeTags = "";
    }

    /**
     * Set depot
     *
     * @param \SearchBundle\Entity\Depot $depot
     *
     * @return Produit
     */
    public function setDepot(\SearchBundle\Entity\Depot $depot)
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * Get depot
     *
     * @return \SearchBundle\Entity\Depot
     */
    public function getDepot()
    {
        return $this->depot;
    }

    /**
     * Add tag
     *
     * @param \SearchBundle\Entity\Tag $tag
     *
     * @return Produit
     */
    public function addTag(\SearchBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \SearchBundle\Entity\Tag $tag
     */
    public function removeTag(\SearchBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function resetTags(){
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
