<?php

namespace Mind\RechercheBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;


class Recherche {
    
    protected $doctrine;
    protected $manager;
    protected $dateFormatage;
    protected $security;
    
    public function __construct(Registry $doctrine, SecurityContextInterface $security) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->security         = $security;
    }
    
    public function getOptionsRecherche(){
        
        
    }
}
