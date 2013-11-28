<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement")
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\AbonnementRepository")
 */
class Abonnement
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
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idUser;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="id_souscripteur", type="integer")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     *  
     */
    private $idSouscripteur;


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
     * @return Abonnement
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
     * Set idSouscripteur
     *
     * @param integer $idSouscripteur
     * @return Abonnement
     */
    public function setIdSouscripteur($idSouscripteur)
    {
        $this->idSouscripteur = intval($idSouscripteur);

        return $this;
    }

    /**
     * Get idSouscripteur
     *
     * @return integer 
     */
    public function getIdSouscripteur()
    {
        return $this->idSouscripteur;
    }
}
