<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OpinionAvis
 *
 * @ORM\Table(name="opinion_avis")
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\OpinionAvisRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class OpinionAvis
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
     * @ORM\Column(name="id_avis", type="integer")
     * @ORM\OneToOne(targetEntity="MindSiteBundle\Entity\Avis")
     * @ORM\JoinColumn(name="id_avis", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * 
     */
    private $idAvis;
    
    /**
     * 
     * @ORM\Column(name="date_publication_opinion", type="datetime")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\DateTime(message="Le type n'est pas valide")
     */
    private $datePublicationOpinion;
    
    /**
     *
     * @var type integer
     * 
     * @ORM\Column(name="id_auteur", type="integer")
     * @ORM\OneToOne(targetEntity="MindUserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_membre", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idAuteur;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idAvis
     *
     * @param integer $idAvis
     * @return OpinionAvis
     */
    public function setIdAvis($idAvis)
    {
        $this->idAvis = intval($idAvis);

        return $this;
    }

    /**
     * Get idAvis
     *
     * @return integer 
     */
    public function getIdAvis()
    {
        return $this->idAvis;
    }

    /**
     * Set idMembre
     *
     * @param integer $idMembre
     * @return OpinionAvis
     */
    public function setIdAuteur($idMembre)
    {
        $this->idAuteur = intval($idMembre);

        return $this;
    }

    /**
     * Get idMembre
     *
     * @return integer 
     */
    public function getIdAuteur()
    {
        return $this->idAuteur;
    }

    /**
     * Set typeOpinion
     *
     * @param integer $typeOpinion
     * @return OpinionAvis
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return OpinionAvis
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
     * Set datePublicationOpinion
     *
     * @param \DateTime $datePublicationOpinion
     * @return OpinionAvis
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
}
