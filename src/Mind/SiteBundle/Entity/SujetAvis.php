<?php

namespace Mind\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SujetAvis
 *
 * @ORM\Table(name="sujet_avis")
 * @ORM\Entity(repositoryClass="Mind\SiteBundle\Entity\SujetAvisRepository")
 */
class SujetAvis
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
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\OneToOne(targetEntity="Mind\SiteBundle\Entity\Avis", cascade={"persist"}, mappedBy="sujet")
     */
    private $Avis;
    

    

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
     * @return SujetAvis
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
     * Set Avis
     *
     * @param integer $avis
     * @return SujetAvis
     */
    public function setAvis($avis)
    {
        $this->Avis = $avis;

        return $this;
    }

    /**
     * Get Avis
     *
     * @return \MindSiteBundle\Entity\Avis 
     */
    public function getAvis()
    {
        return $this->Avis;
    }
}
