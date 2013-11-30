<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Suivis
 *
 * @ORM\Table(name="suivis")
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\SuivisRepository")
 */
class Suivis
{
    
    public function __construct() {
        
        $this->disabled = 0;
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
     * @Assert\NotBlank(message="Le champ id user est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_entity", type="integer")
     * 
     * @Assert\NotBlank(message="Le champ id entity est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idEntity;

    /**
     * @var string
     *
     * @ORM\Column(name="type_entity", type="string", length=10)
     * 
     * @Assert\NotBlank(message="Le champ type entity est obligatoire.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $typeEntity;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disabled", type="boolean")
     * 
     * @Assert\NotBlank(message="Le champ disabled est obligatoire.")
     * @Assert\Type(type="boolean", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $disabled;


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
     * @return Suivis
     */
    public function setIdUser($idUser)
    {
        $this->idUser = intval($idUser);

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
     * Set idEntity
     *
     * @param integer $idEntity
     * @return Suivis
     */
    public function setIdEntity($idEntity)
    {
        $this->idEntity = intval($idEntity);

        return $this;
    }

    /**
     * Get idEntity
     *
     * @return integer 
     */
    public function getIdEntity()
    {
        return $this->idEntity;
    }

    /**
     * Set typeEntity
     *
     * @param string $typeEntity
     * @return Suivis
     */
    public function setTypeEntity($typeEntity)
    {
        $this->typeEntity = $typeEntity;

        return $this;
    }

    /**
     * Get typeEntity
     *
     * @return string 
     */
    public function getTypeEntity()
    {
        return $this->typeEntity;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     * @return Suivis
     */
    public function setDisabled($disabled)
    {
        if($disabled = 0){
            $this->disabled = false;
        }else{
            $this->disabled = true;
        }

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean 
     */
    public function getDisabled()
    {
        return $this->disabled;
    }
}
