<?php

namespace Mind\SiteBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Routing\Router;

class Domaine { 
    
    protected $doctrine;
    protected $manager;
    protected $security;
    protected $router;


    public function __construct(Registry $doctrine, SecurityContextInterface $security, Router $router) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->security         = $security;
        $this->router           = $router;
        
    }
}

?>
