<?php

namespace Mind\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SujetQuestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mind\SiteBundle\Entity\SujetQuestionRepository")
 */
class SujetQuestion
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     *
     * @var type integer
     * 
     * @ORM\Column(name="id_question", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Question")
     * @ORM\JoinColumn(name="id_question", referencedColumnName="id")
     */
    private $idAvis;

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
     * Set libelle
     *
     * @param string $libelle
     * @return SujetQuestion
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set idAvis
     *
     * @param integer $idAvis
     * @return SujetQuestion
     */
    public function setIdAvis($idAvis)
    {
        $this->idAvis = $idAvis;

        return $this;
    }

    /**
     * Get idAvis
     *
     * @return integer 
     */
    public function getIdAvis()
    {
        return $this->idAvis;
    }
}
