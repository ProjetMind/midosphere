<?php

namespace Mind\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Domaine
 * 
 *@Gedmo\Tree(type="nested")
 * @ORM\Table(name="domaine")
 * @ORM\Entity(repositoryClass="Mind\SiteBundle\Entity\DomaineRepository")
 */
class Domaine implements \Gedmo\Tree\Node
{
    
    public function __construct() {
        
        $this->dateCreation = new \DateTime();
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var \integer
     * 
     * @ORM\Column(name="id_auteur", type="integer")
     * @ORM\OneToOne(targetEntity="MindUserBundle\Entity\user")
     * @ORM\JoinColumn(name="id_auteur", referencedColumnName="id")
     * 
     * 
     */
    private $idAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=50)
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     */
    private $libelle;
    
    /**
     * @Gedmo\Slug(fields={"libelle"})
     * @ORM\Column(name="slug", unique=true)
     */
    private $slug;
    
    /**
     *
     * @var type bool
     * 
     * @ORM\Column(name="etat", type="boolean")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     */
    private $etat;
    
    /**
     *
     * @var \DateTime
     * 
     * @ORM\Column(name="date_creation", type="datetime")
     * @Assert\DateTime(message="Ce champ doit être de type date.")
     * 
     */
    private $dateCreation;
    
    /**
     *
     * @var type \DateTime
     * 
     * @ORM\Column(name="date_update", type="datetime", nullable=true)
     * @Assert\DateTime(message="Ce champ doit être de type date.")
     * 
     */
    private $dateUpdate;
    
    /**
     *
     * @var integer
     * 
     * @Gedmo\TreeLevel
     * @ORM\Column(name="niveau", type="integer")
     * 
     */
    private $niveau;
    
    /**
     *
     * @var integer
     *
     * @Gedmo\TreeLeft 
     * @ORM\Column(name="borne_gauche", type="integer")
     */
    private $borneGauche;
    
    /**
     *
     * @var integer
     * 
     * @Gedmo\TreeRight
     * @ORM\Column(name="borne_droit", type="integer")
     */
    private $borneDroit;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Domaine", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Domaine", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;
    
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idAuteur
     *
     * @param integer $idAuteur
     * @return Domaine
     */
    public function setIdAuteur($idAuteur)
    {
        $this->idAuteur = $idAuteur;

        return $this;
    }

    /**
     * Get idAuteur
     *
     * @return integer 
     */
    public function getIdAuteur()
    {
        return $this->idAuteur;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Domaine
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return Domaine
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Domaine
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     * @return Domaine
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set niveau
     *
     * @param integer $niveau
     * @return Domaine
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set borneGauche
     *
     * @param integer $borneGauche
     * @return Domaine
     */
    public function setBorneGauche($borneGauche)
    {
        $this->borneGauche = $borneGauche;

        return $this;
    }

    /**
     * Get borneGauche
     *
     * @return integer 
     */
    public function getBorneGauche()
    {
        return $this->borneGauche;
    }

    /**
     * Set borneDroit
     *
     * @param integer $borneDroit
     * @return Domaine
     */
    public function setBorneDroit($borneDroit)
    {
        $this->borneDroit = $borneDroit;

        return $this;
    }

    /**
     * Get borneDroit
     *
     * @return integer 
     */
    public function getBorneDroit()
    {
        return $this->borneDroit;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Domaine
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param \MindSiteBundle\Entity\Domaine $parent
     * @return Domaine
     */
    public function setParent(Domaine $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \MindSiteBundle\Entity\Domaine 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \MindSiteBundle\Entity\Domaine $children
     * @return Domaine
     */
    public function addChild(Domaine $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \MindSiteBundle\Entity\Domaine $children
     */
    public function removeChild(Domaine $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Domaine
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
