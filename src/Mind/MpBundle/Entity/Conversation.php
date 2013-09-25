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
        $this->etat = true;
        $this->dossier = "bal";
        
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
     * @var string
     * 
     * @ORM\Column(name="dossier", type="text", length=10)
     */
    private $dossier;
    
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
     * @var type Array
     * 
     * @ORM\Column(name="tab_participants", type="array")
     * @ORM\OneToMany(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="tab_participants", referencedColumnName="id")
     */
    private $tabParticipants;

    /**
     *
     * @var DateTime
     * 
     * @ORM\Column(name="date_debut_conversation", type="datetime")
     */
    private $dateDebutConversation;
    
    /**
     *
     * @var bool
     * 
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;



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
     * Set tabParticipants
     *
     * @param array $tabParticipants
     * @return Conversation
     */
    public function setTabParticipants($tabParticipants)
    {
        $this->tabParticipants = $tabParticipants;

        return $this;
    }

    /**
     * Get tabParticipants
     *
     * @return array 
     */
    public function getTabParticipants()
    {
        return $this->tabParticipants;
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

    /**
     * Set etat
     *
     * @param boolean $etat
     * @return Conversation
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set dossier
     *
     * @param string $dossier
     * @return Conversation
     */
    public function setDossier($dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return string 
     */
    public function getDossier()
    {
        return $this->dossier;
    }
}
