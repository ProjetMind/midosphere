<?php

namespace Mind\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VoteAvis
 *
 * @ORM\Table(name="vote_avis")
 * @ORM\Entity(repositoryClass="Mind\UserBundle\Entity\VoteAvisRepository")
 */
class VoteAvis
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
     * @var \DateTime
     *
     * @ORM\Column(name="avis_date_vote", type="datetime")
     */
    private $avisDateVote;
    
    /**
     *
     * @var type \integer
     * 
     * @ORM\Column(name="avis_nature_vote", type="smallint", length=3)
     * 
     */
    private $avisNatureVote;
    
    //RELATION AVEC LES AUTRES ENTITES
    
    /**
     * Un vote est fait par un et un seul user
     * @var type integer
     * 
     * @ORM\Column(name="avis_auteur_vote", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="avis_auteur_vote", referencedColumnName="id")
     */
    private $avisAuteurVote;
    
    /**
     *
     * @var type integer
     * 
     * @ORM\Column(name="avis", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Avis")
     * @ORM\JoinColumn(name="avis", referencedColumnName="id")
     */
    private $avis;


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
     * Set avisDateVote
     *
     * @param \DateTime $avisDateVote
     * @return VoteAvis
     */
    public function setAvisDateVote($avisDateVote)
    {
        $this->avisDateVote = $avisDateVote;

        return $this;
    }

    /**
     * Get avisDateVote
     *
     * @return \DateTime 
     */
    public function getAvisDateVote()
    {
        return $this->avisDateVote;
    }

    /**
     * Set avisNatureVote
     *
     * @param integer $avisNatureVote
     * @return VoteAvis
     */
    public function setAvisNatureVote($avisNatureVote)
    {
        $this->avisNatureVote = $avisNatureVote;

        return $this;
    }

    /**
     * Get avisNatureVote
     *
     * @return integer 
     */
    public function getAvisNatureVote()
    {
        return $this->avisNatureVote;
    }

    /**
     * Set avisAuteurVote
     *
     * @param integer $avisAuteurVote
     * @return VoteAvis
     */
    public function setAvisAuteurVote($avisAuteurVote)
    {
        $this->avisAuteurVote = $avisAuteurVote;

        return $this;
    }

    /**
     * Get avisAuteurVote
     *
     * @return integer 
     */
    public function getAvisAuteurVote()
    {
        return $this->avisAuteurVote;
    }

    /**
     * Set avis
     *
     * @param integer $avis
     * @return VoteAvis
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;

        return $this;
    }

    /**
     * Get avis
     *
     * @return integer 
     */
    public function getAvis()
    {
        return $this->avis;
    }
}
