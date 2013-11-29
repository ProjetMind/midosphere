<?php

namespace Mind\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VoteQuestion
 *
 * @ORM\Table(name="vote_question")
 * @ORM\Entity(repositoryClass="Mind\UserBundle\Entity\VoteQuestionRepository")
 */
class VoteQuestion
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
     * @ORM\Column(name="question_date_vote", type="datetime")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\DateTime(message="Le type de champ n'est valide.")
     */
    private $questionDateVote;
    
    /**
     *
     * @var type \integer
     * 
     * @ORM\Column(name="question_nature_vote", type="smallint", length=3)
     * 
     */
    private $questionNatureVote;
    
    //RELATION AVEC LES AUTRES ENTITES
    
    /**
     * Un vote est fait par un et un seul user
     * @var type integer
     * 
     * @ORM\Column(name="question_auteur_vote", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="question_auteur_vote", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $questionAuteurVote;
    
    /**
     *
     * @var type integer
     * 
     * @ORM\Column(name="avis", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Avis")
     * @ORM\JoinColumn(name="question", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $question;


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
     * Set questionDateVote
     *
     * @param \DateTime $questionDateVote
     * @return VoteQuestion
     */
    public function setQuestionDateVote($questionDateVote)
    {
        $this->questionDateVote = $questionDateVote;

        return $this;
    }

    /**
     * Get questionDateVote
     *
     * @return \DateTime 
     */
    public function getQuestionDateVote()
    {
        return $this->questionDateVote;
    }

    /**
     * Set questionNatureVote
     *
     * @param integer $questionNatureVote
     * @return VoteQuestion
     */
    public function setQuestionNatureVote($questionNatureVote)
    {
        $this->questionNatureVote = $questionNatureVote;

        return $this;
    }

    /**
     * Get questionNatureVote
     *
     * @return integer 
     */
    public function getQuestionNatureVote()
    {
        return $this->questionNatureVote;
    }

    /**
     * Set questionAuteurVote
     *
     * @param integer $questionAuteurVote
     * @return VoteQuestion
     */
    public function setQuestionAuteurVote($questionAuteurVote)
    {
        $this->questionAuteurVote = intval($questionAuteurVote);

        return $this;
    }

    /**
     * Get questionAuteurVote
     *
     * @return integer 
     */
    public function getQuestionAuteurVote()
    {
        return $this->questionAuteurVote;
    }

    /**
     * Set question
     *
     * @param integer $question
     * @return VoteQuestion
     */
    public function setQuestion($question)
    {
        $this->question = intval($question);

        return $this;
    }

    /**
     * Get question
     *
     * @return integer 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
