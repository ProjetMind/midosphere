<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $idUser;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="id_souscripteur", type="integer")
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
     * Set idSouscripteur
     *
     * @param integer $idSouscripteur
     * @return Abonnement
     */
    public function setIdSouscripteur($idSouscripteur)
    {
        $this->idSouscripteur = $idSouscripteur;

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
