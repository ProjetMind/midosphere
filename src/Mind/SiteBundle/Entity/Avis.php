<?php

namespace Mind\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Avis
 *
 * @ORM\Table(name="avis")
 * @ORM\Entity(repositoryClass="Mind\SiteBundle\Entity\AvisRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Avis
{
    
    public function __construct() {
     
        $this->avisDatePublication = new \DateTime();
        $this->avisDateEdition = null;
    }
    
    /**
     * @var integer integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     *
     * @var type \string
     * 
     * @ORM\Column(name="avis_titre", type="string", length=100)
     * 
     */
    private $avisTitre;
    
    /**
     * 
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\InversedRelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationClass", value="Mind\UserBundle\Entity\User"),
     *          @Gedmo\SlugHandlerOption(name="mappedBy", value="username"),
     *          @Gedmo\SlugHandlerOption(name="inverseSlugField", value="slug")
     *      })
     * }, fields={"avisTitre"})
     * 
     * @ORM\Column(name="slug", unique=true)
     */
    private $slug;
    
    /**
     * @var \text
     *
     * @ORM\Column(name="avis", type="text")
     * 
     */
    private $avis;
    
    /**
     *
     * @var type integer
     * 
     * @ORM\Column(name="type_opinion", type="integer", length=3)
     */
    private $typeOpinion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="avis_date_publication", type="datetime")
     */
    private $avisDatePublication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="avis_date_edition", type="datetime", nullable=true)
     */
    private $avisDateEdition;

    
    //RELATIONS AVEC LES AUTRES ENTITE
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="avis_auteur", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="avis_auteur", referencedColumnName="id")
     */
    private $avisAuteur;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="avis_adresse", type="integer", nullable=true)
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Adresse")
     * @ORM\JoinColumn(name="avis_adresse", referencedColumnName="id")
     */
    private $avisAdresse;
    
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="avis_domaine", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Domaine" )
     * @ORM\JoinColumn(name="domaine_id", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Vous devez indiquez un domaine.")
     */
    private $avisDomaine;
    
    private $file;


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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Avis
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set avisTitre
     *
     * @param string $avisTitre
     * @return Avis
     */
    public function setAvisTitre($avisTitre)
    {
        $this->avisTitre = $avisTitre;

        return $this;
    }

    /**
     * Get avisTitre
     *
     * @return string 
     */
    public function getAvisTitre()
    {
        return $this->avisTitre;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Avis
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

    /**
     * Set avis
     *
     * @param string $avis
     * @return Avis
     */
    public function setAvis($avis)
    {
        $this->avis = nl2br($avis);

        return $this;
    }

    /**
     * Get avis
     *
     * @return string 
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * Set typeOpinion
     *
     * @param integer $typeOpinion
     * @return Avis
     */
    public function setTypeOpinion($typeOpinion)
    {
        $this->typeOpinion = $typeOpinion;

        return $this;
    }

    /**
     * Get typeOpinion
     *
     * @return integer 
     */
    public function getTypeOpinion()
    {
        return $this->typeOpinion;
    }

    /**
     * Set avisDatePublication
     *
     * @param \DateTime $avisDatePublication
     * @return Avis
     */
    public function setAvisDatePublication($avisDatePublication)
    {
        $this->avisDatePublication = $avisDatePublication;

        return $this;
    }

    /**
     * Get avisDatePublication
     *
     * @return \DateTime 
     */
    public function getAvisDatePublication()
    {
        return $this->avisDatePublication;
    }

    /**
     * Set avisDateEdition
     *
     * @param \DateTime $avisDateEdition
     * @return Avis
     */
    public function setAvisDateEdition($avisDateEdition)
    {
        $this->avisDateEdition = $avisDateEdition;

        return $this;
    }

    /**
     * Get avisDateEdition
     *
     * @return \DateTime 
     */
    public function getAvisDateEdition()
    {
        return $this->avisDateEdition;
    }

    /**
     * Set avisAuteur
     *
     * @param integer $avisAuteur
     * @return Avis
     */
    public function setAvisAuteur($avisAuteur)
    {
        $this->avisAuteur = $avisAuteur;

        return $this;
    }

    /**
     * Get avisAuteur
     *
     * @return integer 
     */
    public function getAvisAuteur()
    {
        return $this->avisAuteur;
    }

    /**
     * Set avisAdresse
     *
     * @param integer $avisAdresse
     * @return Avis
     */
    public function setAvisAdresse($avisAdresse)
    {
        $this->avisAdresse = $avisAdresse;

        return $this;
    }

    /**
     * Get avisAdresse
     *
     * @return integer 
     */
    public function getAvisAdresse()
    {
        return $this->avisAdresse;
    }

    /**
     * Set avisDomaine
     *
     * @param integer $avisDomaine
     * @return Avis
     */
    public function setAvisDomaine($avisDomaine)
    {
        $this->avisDomaine = $avisDomaine;

        return $this;
    }

    /**
     * Get avisDomaine
     *
     * @return integer 
     */
    public function getAvisDomaine()
    {
        return $this->avisDomaine;
    }
    
    public function getFile(){
        return $this->file;
    }
    
    public function setFile($file){
        $this->file = $file;
    }
}
