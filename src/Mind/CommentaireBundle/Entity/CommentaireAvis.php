<?php

namespace Mind\CommentaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CommentaireAvis
 *
 * @ORM\Table(name="commentaire_avis")
 * @ORM\Entity(repositoryClass="Mind\CommentaireBundle\Entity\CommentaireAvisRepository")
 */
class CommentaireAvis
{
    
    public function __construct() {
        
        $this->commentaireDatePublication = new \DateTime;
        
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
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="commentaire_date_publication", type="datetime")
     */
    private $commentaireDatePublication;

    //RELATIONS AVEC LES AUTRES ENTITE
    
    /**
     *
     * @var type integer
     * @ORM\Column(name="id_avis", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Avis")
     * @ORM\JoinColumn(name="id_avis", referencedColumnName="id")
     */
    private $idAvis;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="commentaire_id_auteur", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="commentaire_id_auteur", referencedColumnName="id")
     */
    private $commentaireIdAuteur;

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
     * @return CommentaireAvis
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
     * Set commentaireIdAuteur
     *
     * @param integer $commentaireIdAuteur
     * @return CommentaireAvis
     */
    public function setCommentaireIdAuteur($commentaireIdAuteur)
    {
        $this->commentaireIdAuteur = $commentaireIdAuteur;

        return $this;
    }

    /**
     * Get commentaireIdAuteur
     *
     * @return integer 
     */
    public function getCommentaireIdAuteur()
    {
        return $this->commentaireIdAuteur;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return CommentaireAvis
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set commentaireDatePublication
     *
     * @param \DateTime $commentaireDatePublication
     * @return CommentaireAvis
     */
    public function setCommentaireDatePublication($commentaireDatePublication)
    {
        $this->commentaireDatePublication = $commentaireDatePublication;

        return $this;
    }

    /**
     * Get commentaireDatePublication
     *
     * @return \DateTime 
     */
    public function getCommentaireDatePublication()
    {
        return $this->commentaireDatePublication;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return CommentaireAvis
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
