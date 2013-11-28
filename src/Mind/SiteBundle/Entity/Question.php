<?php

namespace Mind\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="Mind\SiteBundle\Entity\QuestionRepository")
 */
class Question
{
    public function __construct() {
        
        $this->questionDatePublication = new \DateTime;
        $this->questionDateEdition = null;
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
     * @var string
     *
     * @ORM\Column(name="question_titre", type="string", length=200)
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="string", message="La valeur '{{ value }}' n'est pas un type {{ type }} valide.")
     * @Assert\Length(
     *      min = "2",
     *      max = "200",
     *      minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     * 
     */
    private $questionTitre;
    
    /**
     * @Gedmo\Slug(fields={"questionTitre"})
     * @ORM\Column(name="slug", unique=true)
     */
    private $slug;

    /**
     * @var text
     *
     * @ORM\Column(name="question", type="text")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $question;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="question_date_publication", type="datetime")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\DateTime(message="Le type n'est pas valide.")
     * 
     */
    private $questionDatePublication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="question_date_edition", type="datetime", nullable=true)
     * 
     * @Assert\DateTime(message="Le type n'est pas valide.")
     */
    private $questionDateEdition;
    
    //RELATION AVEC LES AUTRES ENTIT2S
    
    /**
     *
     * @var Integer
     * 
     * @ORM\Column(name="question_auteur", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="question_auteur", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $questionAuteur;
    
    /**
     *
     * @var array
     * 
     * @ORM\Column(name="question_domaine", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Domaine")
     * @ORM\JoinColumn(name="question_domaine", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Vous devez indiquez un domaine.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * 
     */
    private $questionDomaine;
    

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
     * Set questionTitre
     *
     * @param string $questionTitre
     * @return Question
     */
    public function setQuestionTitre($questionTitre)
    {
        $this->questionTitre = $questionTitre;

        return $this;
    }

    /**
     * Get questionTitre
     *
     * @return string 
     */
    public function getQuestionTitre()
    {
        return $this->questionTitre;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = nl2br($question);

        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set questionDatePublication
     *
     * @param \DateTime $questionDatePublication
     * @return Question
     */
    public function setQuestionDatePublication($questionDatePublication)
    {
        $this->questionDatePublication = $questionDatePublication;

        return $this;
    }

    /**
     * Get questionDatePublication
     *
     * @return \DateTime 
     */
    public function getQuestionDatePublication()
    {
        return $this->questionDatePublication;
    }

    /**
     * Set questionDateEdition
     *
     * @param \DateTime $questionDateEdition
     * @return Question
     */
    public function setQuestionDateEdition($questionDateEdition)
    {
        $this->questionDateEdition = $questionDateEdition;

        return $this;
    }

    /**
     * Get questionDateEdition
     *
     * @return \DateTime 
     */
    public function getQuestionDateEdition()
    {
        return $this->questionDateEdition;
    }

    /**
     * Set questionAuteur
     *
     * @param integer $questionAuteur
     * @return Question
     */
    public function setQuestionAuteur($questionAuteur)
    {
        $this->questionAuteur = intval($questionAuteur);

        return $this;
    }

    /**
     * Get questionAuteur
     *
     * @return integer 
     */
    public function getQuestionAuteur()
    {
        return $this->questionAuteur;
    }

    /**
     * Set questionDomaine
     *
     * @param integer $questionDomaine
     * @return Question
     */
    public function setQuestionDomaine($questionDomaine)
    {
        $this->questionDomaine = intval($questionDomaine);

        return $this;
    }

    /**
     * Get questionDomaine
     *
     * @return integer
     */
    public function getQuestionDomaine()
    {
        return $this->questionDomaine;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Question
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
