<?php

namespace Mind\CommentaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentaireQuestion
 *
 * @ORM\Table(name="commentaire_question")
 * @ORM\Entity(repositoryClass="Mind\CommentaireBundle\Entity\CommentaireQuestionRepository")
 */
class CommentaireQuestion
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
     * @var integer
     *
     * @ORM\Column(name="id_question", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Question")
     * @ORM\JoinColumn(name="id_question", referencedColumnName="id")
     */
    private $idQuestion;

    /**
     * @var integer
     *
     * @ORM\Column(name="commentaire_id_auteur", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="commentaire_id_auteur", referencedColumnName="id")
     */
    private $commentaireIdAuteur;

    /**
     * @var text
     *
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="commentaire_date_publication", type="datetime")
     */
    private $commentaireDatePublication;


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
     * Set idQuestion
     *
     * @param integer $idQuestion
     * @return CommentaireQuestion
     */
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion = $idQuestion;

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
     * Set commentaireIdAuteur
     *
     * @param integer $commentaireIdAuteur
     * @return CommentaireQuestion
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
     * Set commentaireDatePublication
     *
     * @param \DateTime $commentaireDatePublication
     * @return CommentaireQuestion
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
     * Set commentaire
     *
     * @param integer $commentaire
     * @return CommentaireQuestion
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = nl2br($commentaire);

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return integer 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }


    
}
