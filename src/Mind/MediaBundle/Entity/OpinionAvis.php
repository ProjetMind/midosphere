<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpinionAvis
 *
 * @ORM\Table(name="opinion_avis")
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\OpinionAvisRepository")
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
     * @var integer
     *
     * @ORM\Column(name="id_avis", type="integer")
     * @ORM\OneToOne(targetEntity="MindSiteBundle\Entity\Avis")
     * @ORM\JoinColumn(name="id_avis", referencedColumnName="id")
     * 
     */
    private $idAvis;
    
    /**
     * 
     * @ORM\Column(name="date_publication_opinion", type="datetime")
     */
    private $datePublicationOpinion;
    
    /**
     *
     * @var type integer
     * 
     * @ORM\Column(name="id_auteur", type="integer")
     * @ORM\OneToOne(targetEntity="MindUserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_membre", referencedColumnName="id")
     */
    private $idAuteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="type_opinion", type="integer", length=3)
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
        $this->idAvis = $idAvis;

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
        $this->idAuteur = $idMembre;

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
}
