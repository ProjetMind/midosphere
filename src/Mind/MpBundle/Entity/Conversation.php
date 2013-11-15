<?php

namespace Mind\MpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 *
 * @ORM\Table(name="conversation")
 * @ORM\Entity(repositoryClass="Mind\MpBundle\Entity\ConversationRepository")
 */
class Conversation
{
    
    public function __construct() {
        
        $this->dateDebutConversation = new \DateTime();
        
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
     *
     * @var integer
     * 
     * @ORM\Column(name="auteur_conversation", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="auteur_conversation", referencedColumnName="id")
     */
    private $auteurConversation;

    /**
     *
     * @var DateTime
     * 
     * @ORM\Column(name="date_debut_conversation", type="datetime")
     */
    private $dateDebutConversation;
    
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
     * Set auteurConversation
     *
     * @param integer $auteurConversation
     * @return Conversation
     */
    public function setAuteurConversation($auteurConversation)
    {
        $this->auteurConversation = $auteurConversation;

        return $this;
    }

    /**
     * Get auteurConversation
     *
     * @return integer 
     */
    public function getAuteurConversation()
    {
        return $this->auteurConversation;
    }

    /**
     * Set dateDebutConversation
     *
     * @param \DateTime $dateDebutConversation
     * @return Conversation
     */
    public function setDateDebutConversation($dateDebutConversation)
    {
        $this->dateDebutConversation = $dateDebutConversation;

        return $this;
    }

    /**
     * Get dateDebutConversation
     *
     * @return \DateTime 
     */
    public function getDateDebutConversation()
    {
        return $this->dateDebutConversation;
    }
    
}
