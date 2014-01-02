<?php

namespace Mind\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VoteCommentaire
 *
 * @ORM\Table(name="vote_commentaire")
 * @ORM\Entity(repositoryClass="Mind\UserBundle\Entity\VoteCommentaireRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class VoteCommentaire
{
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
     * @var \DateTime
     *
     * @ORM\Column(name="commentaire_date_vote", type="datetime")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\DateTime(message="Le type de champ n'est valide.")
     */
    private $commentaireDateVote;
    
    /**
     *
     * @var type \integer
     * 
     * @ORM\Column(name="commentaire_nature_vote", type="smallint", length=3)
     * 
     */
    private $commentaireNatureVote;
    
    //RELATION AVEC LES AUTRES ENTITES
    
    /**
     * Un vote est fait par un et un seul user
     * @var type integer
     * 
     * @ORM\Column(name="commentaire_auteur_vote", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="commentaire_auteur_vote", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $commentaireAuteurVote;
    
    /**
     *
     * @var type integer
     * 
     * @ORM\Column(name="commentaire", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Avis")
     * @ORM\JoinColumn(name="commentaire", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $commentaire;


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
     * Set commentaireDateVote
     *
     * @param \DateTime $commentaireDateVote
     * @return VoteCommentaire
     */
    public function setCommentaireDateVote($commentaireDateVote)
    {
        $this->commentaireDateVote = $commentaireDateVote;

        return $this;
    }

    /**
     * Get commentaireDateVote
     *
     * @return \DateTime 
     */
    public function getCommentaireDateVote()
    {
        return $this->commentaireDateVote;
    }

    /**
     * Set commentaireNatureVote
     *
     * @param integer $commentaireNatureVote
     * @return VoteCommentaire
     */
    public function setCommentaireNatureVote($commentaireNatureVote)
    {
        $this->commentaireNatureVote = $commentaireNatureVote;

        return $this;
    }

    /**
     * Get commentaireNatureVote
     *
     * @return integer 
     */
    public function getCommentaireNatureVote()
    {
        return $this->commentaireNatureVote;
    }

    /**
     * Set commentaireAuteurVote
     *
     * @param integer $commentaireAuteurVote
     * @return VoteCommentaire
     */
    public function setCommentaireAuteurVote($commentaireAuteurVote)
    {
        $this->commentaireAuteurVote = intval($commentaireAuteurVote);

        return $this;
    }

    /**
     * Get commentaireAuteurVote
     *
     * @return integer 
     */
    public function getCommentaireAuteurVote()
    {
        return $this->commentaireAuteurVote;
    }

    /**
     * Set commentaire
     *
     * @param integer $commentaire
     * @return VoteCommentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = intval($commentaire);

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

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return VoteCommentaire
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
