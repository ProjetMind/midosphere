<?php

namespace Mind\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mind\SiteBundle\Entity\AdresseRepository")
 */
class Adresse
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
     * @ORM\Column(name="adresse_adresse", type="string", length=150)
     */
    private $adresseAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_ville", type="string", length=50)
     */
    private $adresseVille;

    /**
     * @var integer
     *
     * @ORM\Column(name="adresse_cp", type="integer")
     */
    private $adresseCp;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_pays", type="string", length=50)
     */
    private $adressePays;
    
    //LES RELATIONS AVEC LES AUTRES ENTITES
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="avis", type="integer")
     * @ORM\OneToOne(targetEntity="Mind\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="avis", referencedColumnName="id")
     */
    private $avis;


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
     * Set adresseAdresse
     *
     * @param string $adresseAdresse
     * @return Adresse
     */
    public function setAdresseAdresse($adresseAdresse)
    {
        $this->adresseAdresse = $adresseAdresse;

        return $this;
    }

    /**
     * Get adresseAdresse
     *
     * @return string 
     */
    public function getAdresseAdresse()
    {
        return $this->adresseAdresse;
    }

    /**
     * Set adresseVille
     *
     * @param string $adresseVille
     * @return Adresse
     */
    public function setAdresseVille($adresseVille)
    {
        $this->adresseVille = $adresseVille;

        return $this;
    }

    /**
     * Get adresseVille
     *
     * @return string 
     */
    public function getAdresseVille()
    {
        return $this->adresseVille;
    }

    /**
     * Set adresseCp
     *
     * @param integer $adresseCp
     * @return Adresse
     */
    public function setAdresseCp($adresseCp)
    {
        $this->adresseCp = $adresseCp;

        return $this;
    }

    /**
     * Get adresseCp
     *
     * @return integer 
     */
    public function getAdresseCp()
    {
        return $this->adresseCp;
    }

    /**
     * Set adressePays
     *
     * @param string $adressePays
     * @return Adresse
     */
    public function setAdressePays($adressePays)
    {
        $this->adressePays = $adressePays;

        return $this;
    }

    /**
     * Get adressePays
     *
     * @return string 
     */
    public function getAdressePays()
    {
        return $this->adressePays;
    }

    /**
     * Set avis
     *
     * @param integer $avis
     * @return Adresse
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;

        return $this;
    }

    /**
     * Get avis
     *
     * @return integer 
     */
    public function getAvis()
    {
        return $this->avis;
    }
}
