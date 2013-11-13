<?php

namespace Mind\MpBundle\Doctrine\Manager;

use Mind\MpBundle\Doctrine\Manager\BaseManager;

class ConversationManager extends BaseManager {    
    
    public function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine, \Mind\SiteBundle\DateFormatage $dateFormatage, \Symfony\Component\Security\Core\SecurityContext $securityContext) {
        parent::__construct($doctrine, $dateFormatage, $securityContext);
    }
}
