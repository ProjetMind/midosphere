<?php

namespace Mind\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Mind\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{   
    public function __construct() {
        
            parent::__construct();
            
            $this->dateInscription  = new \DateTime;
            $this->nom              = 'Diallo';
            $this->prenom           = 'Ibrahim';
            $this->ville            = 'Antony';
            $this->roles            = array('ROLE_ADMIN');
           
        }
        
        
        
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var type string
     * 
     * @ORM\Column(name="nom", type="string", length=100, nullable=true) 
     * 
     * @Assert\Type(type="string", message="le nom doit être une chaine de caractère.")
     * @Assert\Length(
     *                  min=2, max=20, 
     *                  minMessage="Le nom doit faire au moins {{min}} caracrères.", 
     *                  maxMessage="Le nom ne peut pas excédé {{max}} caractères."
     *              )
     * @Assert\Regex(
     *                  pattern ="#^[A-Z][a-z]+(-[A-Z][a-z]+)*$#",
     *                  match = true,
     *                  message = "Le format du nom n'est pas correct."
     *                )
     */
    private $nom;
    
    /**
     *
     * @var type 
     * 
     * @ORM\Column(name="path", nullable=true)
     */
    private $path;
    
    /**
     * @Gedmo\Slug(fields={"username"})
     * @ORM\Column(name="slug", unique=true)
     */
    private $slug;
    
    /**
     *
     * @var type string
     * 
     * @ORM\Column(name="prenom", type="string", length=100, nullable=true)
     * 
     * @Assert\Type(type="string", message="Le prénom doit être une chaine de caractère.")
     * @Assert\Length(
     *                  min=2, max=20, 
     *                  minMessage="Le prénom doit faire au moins {{ limit }} caracrères.", 
     *                  maxMessage="Le prénom ne peut pas excédé {{ limit }} caractères."
     *              )
     * @Assert\Regex(
     *                  pattern ="#^[A-Z][a-z]+(-[A-Z][a-z]+)*$#",
     *                  match = true,
     *                  message = "Le format du prénom n'est pas correct."
     *                )
     * 
     */
    private $prenom;
    
    /**
     *
     * @var type date
     * 
     * @ORM\Column(name="date_naissance", type="date")
     * 
     * @Assert\Date(message="La valeur du champ date de naissance n'est pas valide.")
     * @Assert\NotBlank(message="Le champ date de naissance est obligatoire.")
     */
    private $dateNaissance;

    /**
     *
     * @var type boolean
     * 
     * @@ORM\Column(name="sexe", type="boolean")
     * 
     * @Assert\Type(
     *              type="boolean",
     *              message= "Le sexe doit être de type boolean : femme ou homme."
     *              )
     */
    private $sexe;
    
    
    /**
     *
     * @var type string
     * 
     * @ORM\Column(name="pays", type="string", length=50, nullable=true)
     * 
     * @Assert\NotBlank(message="Le champ pays est obligatoire.")
     * @Assert\Type(type="string", message="Le pays doit être une chaine de caractère.")
     * @Assert\Length(
     *                  min=2, max=20, 
     *                  minMessage="Le pays doit faire au moins {{ limit }} caracrères.", 
     *                  maxMessage="Le pays ne peut pas excédé {{ limit }} caractères."
     *              )
     
     * 
     */
    private $pays;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="ville", type="string", length=100, nullable=true)
     * 
     * @Assert\Type(
     *              type="string",
     *              message= "Le sexe doit être de type boolean : femme ou homme."
     *              )
     * 
     * @Assert\Length(
     *                  min=2, max=20, 
     *                  minMessage="Le nom de la ville doit faire au moins {{ limit }} caracrères.", 
     *                  maxMessage="Le nom de la ville ne peut pas excédé {{ limit }} caractères."
     *              )
     * @Assert\Regex(
     *                  pattern ="#^[A-Z][a-z]+(-[A-Z][a-z]+)*$#",
     *                  match = true,
     *                  message = "Le nom de la ville n'est pas correct."
     *                )
     */
    private $ville;

    /**
     *
     * @var type DateTime
     * 
     * @ORM\Column(name="date_inscription", type="datetime")
     * 
     * @Assert\DateTime(message="Le champ date d'inscription doit être de type date.")
     * @Assert\NotBlank(message="Le champ date d'inscription est obligatoire.")
     */
    private $dateInscription;
    
    /**
     *
     * @var type boolean
     * 
     * @ORM\Column(name="cdt_generales", type="boolean")
     * @Assert\NotBlank(message="Vous devez accepté les conditions générales du site.")
     * 
     */
    private $cdtGenerales;
    
    
    /**
     *
     * @var type text
     * 
     * @Orm\Column(name="descrip_user", type="text", nullable=true)
     * 
     * @Assert\Type(type="string", message="La valeur {{ value }} du champ description n'est pas un type {{ type }} valide.")
     */
    private $descripUser;


    //RELATIONS AVEC LES AUTRES ENTITE
    
    
    
    

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
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }
    
    /**
     * Set sexe
     *
     * @param string $sexe
     * @return User
     */
    public function setSexe($sexe)
    {
        if($sexe == 0){
            $this->sexe = false;
        }
        if($sexe == 1)
        {
            $this->sexe = true; 
        }

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Get sexe
     *
     * @return boolean
     */
    public function getSexe()
    {
        return $this->sexe;
    }
    
    /**
     * Set pays
     *
     * @param string $pays
     * @return User
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     * @return User
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime 
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * Set cdtGenerales
     *
     * @param boolean $cdtGenerales
     * @return User
     */
    public function setCdtGenerales($cdtGenerales)
    {
        
        if($cdtGenerales == 0){
            $this->cdtGenerales = false;
        }
        if($cdtGenerales == 1){
            $this->cdtGenerales = true;
        }

        return $this;
    }

    /**
     * Get cdtGenerales
     *
     * @return boolean 
     */
    public function getCdtGenerales()
    {
        return $this->cdtGenerales;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return User
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return User
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
     * Set descripUser
     *
     * @param string $descripUser
     * @return User
     */
    public function setDescripUser($descripUser)
    {
        $this->descripUser = $descripUser;

        return $this;
    }

    /**
     * Get descripUser
     *
     * @return string 
     */
    public function getDescripUser()
    {
        return $this->descripUser;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return User
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
}
