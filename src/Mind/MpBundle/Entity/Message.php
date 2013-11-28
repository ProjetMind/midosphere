<?php

namespace Mind\MpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="Mind\MpBundle\Entity\MessageRepository")
 */
class Message
{
    
    public function __construct() {
        
        $this->dateEnvoiMessage = new \DateTime();
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
     * @ORM\Column(name="id_expediteur", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="auteur_conversation", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * 
     */
    private $idExpediteur;
    
    /**
     *
     * 
     * @var type 
     */
    public $destinataires;

    /**
     * @var text
     *
     * @ORM\Column(name="contenu_message", type="text", length=255)
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * 
     */
    private $contenuMessage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_envoi_message", type="datetime")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\DateTime(message="Le type n'est pas valide.")
     */
    private $dateEnvoiMessage;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_conversation", type="integer")
     * @ORM\OneToOne(targetEntity="MindMessageBundle\Entity\Conversation")
     * @ORM\JoinColumn(name="id_conversation", referencedColumnName="id")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * 
     */
    private $idConversation;


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
     * Set idExpediteur
     *
     * @param integer $idExpediteur
     * @return Message
     */
    public function setIdExpediteur($idExpediteur)
    {
        $this->idExpediteur = intval($idExpediteur);

        return $this;
    }

    /**
     * Get idExpediteur
     *
     * @return integer 
     */
    public function getIdExpediteur()
    {
        return $this->idExpediteur;
    }

    /**
     * Set contenuMessage
     *
     * @param string $contenuMessage
     * @return Message
     */
    public function setContenuMessage($contenuMessage)
    {
        $this->contenuMessage = nl2br($contenuMessage);

        return $this;
    }

    /**
     * Get contenuMessage
     *
     * @return string 
     */
    public function getContenuMessage()
    {
        return $this->contenuMessage;
    }

    /**
     * Set dateEnvoiMessage
     *
     * @param \DateTime $dateEnvoiMessage
     * @return Message
     */
    public function setDateEnvoiMessage($dateEnvoiMessage)
    {
        $this->dateEnvoiMessage = $dateEnvoiMessage;

        return $this;
    }

    /**
     * Get dateEnvoiMessage
     *
     * @return \DateTime 
     */
    public function getDateEnvoiMessage()
    {
        return $this->dateEnvoiMessage;
    }

    /**
     * Set idConversation
     *
     * @param integer $idConversation
     * @return Message
     */
    public function setIdConversation($idConversation)
    {
        $this->idConversation = intval($idConversation);

        return $this;
    }

    /**
     * Get idConversation
     *
     * @return integer 
     */
    public function getIdConversation()
    {
        return $this->idConversation;
    }

}
