<?php

namespace Mind\MpBundle\Doctrine\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Mind\SiteBundle\DateFormatage;
use Symfony\Component\Security\Core\SecurityContext;

class BaseManager {
    
    protected $doctrine;
    protected $manager;
    protected $dateFormatage;
    protected $security;
    
    public function __construct(Registry $doctrine, DateFormatage $dateFormatage, SecurityContext $securityContext) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->dateFormatage    = $dateFormatage;
        $this->security         = $securityContext;
        
    }
}
