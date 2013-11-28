<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbonnementDomaine
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mind\MediaBundle\Entity\AbonnementDomaineRepository")
 */
class AbonnementDomaine
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
     * @var integer
     *
     * @ORM\Column(name="id_domaine", type="integer")
     * 
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     * @Assert\Type(type="int", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $idDomaine;


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
     * @return AbonnementDomaine
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
     * Set idDomaine
     *
     * @param integer $idDomaine
     * @return AbonnementDomaine
     */
    public function setIdDomaine($idDomaine)
    {
        $this->idDomaine = intval($idDomaine);

        return $this;
    }

    /**
     * Get idDomaine
     *
     * @return integer 
     */
    public function getIdDomaine()
    {
        return $this->idDomaine;
    }
}
