<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OpinionQuestion
 *
 * @ORM\Table(name="opinion_question")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\OpinionQuestionRepository")
 */
class OpinionQuestion
{
    
    public function __construct() {
        
        $this->datePublicationOpinion = new \DateTime;
        
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
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id_auteur", type="integer")
     * @ORM\OneToOne(targetEntity="MindUserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_auteur", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idAuteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_question", type="integer")
     * @ORM\OneToOne(targetEntity="MindSiteBundle\Entity\Question")
     * @ORM\JoinColumn(name="id_question", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idQuestion;

    /**
     * @var integer
     *
     * @ORM\Column(name="type_opinion", type="integer", length=3)
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $typeOpinion;
    
    /**
     * 
     * @ORM\Column(name="date_publication_opinion", type="datetime")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\DateTime(message="Le type n'est pas valide.")
     */
    private $datePublicationOpinion;


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
     * @return OpinionQuestion
     */
    public function setIdAuteur($idAuteur)
    {
        $this->idAuteur = intval($idAuteur);

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
     * Set idQuestion
     *
     * @param integer $idQuestion
     * @return OpinionQuestion
     */
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion = intval($idQuestion);

        return $this;
    }

    /**
     * Get idQuestion
     *
     * @return integer 
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * Set typeOpinion
     *
     * @param integer $typeOpinion
     * @return OpinionQuestion
     */
    public function setTypeOpinion($typeOpinion)
    {
        $this->typeOpinion = intval($typeOpinion);

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
     * Set datePublicationOpinion
     *
     * @param \DateTime $datePublicationOpinion
     * @return OpinionQuestion
     */
    public function setDatePublicationOpinion($datePublicationOpinion)
    {
        $this->datePublicationOpinion = $datePublicationOpinion;

        return $this;
    }

    /**
     * Get datePublicationOpinion
     *
     * @return \DateTime 
     */
    public function getDatePublicationOpinion()
    {
        return $this->datePublicationOpinion;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return OpinionQuestion
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
}
