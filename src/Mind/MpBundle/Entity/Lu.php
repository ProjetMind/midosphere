<?php

namespace Mind\MpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Lu
 *
 * @ORM\Table(name="lu")
 * @ORM\Entity(repositoryClass="Mind\MpBundle\Entity\LuRepository")
 */
class Lu
{
    
    public function __construct() {
        
        $this->lu       = FALSE;
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
     * @ORM\Column(name="id_user", type="integer")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_message", type="integer")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idMessage;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_conversation", type="integer")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idConversation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lu", type="boolean")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="boolean", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $lu;


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
     * Set idUser
     *
     * @param integer $idUser
     * @return Lu
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idMessage
     *
     * @param integer $idMessage
     * @return Lu
     */
    public function setIdMessage($idMessage)
    {
        $this->idMessage = $idMessage;

        return $this;
    }

    /**
     * Get idMessage
     *
     * @return integer 
     */
    public function getIdMessage()
    {
        return $this->idMessage;
    }

    /**
     * Set idConversation
     *
     * @param integer $idConversation
     * @return Lu
     */
    public function setIdConversation($idConversation)
    {
        $this->idConversation = $idConversation;

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

    /**
     * Set lu
     *
     * @param boolean $lu
     * @return Lu
     */
    public function setLu($lu)
    {
        $this->lu = $lu;

        return $this;
    }

    /**
     * Get lu
     *
     * @return boolean 
     */
    public function getLu()
    {
        return $this->lu;
    }
}
