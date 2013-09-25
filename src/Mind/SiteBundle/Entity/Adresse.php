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

}
