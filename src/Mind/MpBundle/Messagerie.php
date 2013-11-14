<?php

namespace Mind\MpBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Routing\Router;
use Mind\SiteBundle\DateFormatage;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Messagerie {
    
    protected $doctrine;
    protected $manager;
    protected $router;
    protected $dateFormatage;
    protected $securityContext;
    protected $idUserCourant;
    protected $conversation;
    protected $messageManager;
    protected $containerManager;


    public function __construct(Registry $doctrine, Router $router, DateFormatage $dateFormatage, SecurityContext $securityContext,
                                ContainerInterface $container) {
        
        $this->doctrine         = $doctrine;
        $this->router           = $router;
        $this->manager          = $doctrine->getManager();
        $this->dateFormatage    = $dateFormatage;
        $this->securityContext  = $securityContext;
        $this->idUserCourant    = $securityContext->getToken()->getUser()->getId();
        $this->conversationManager     = $container->get('mind_mp.conversation');
        $this->messageManager   = $container->get('mind_mp.message');
        
    }
    
    public function create(){
        
        $message        = $this->messageManager->createMessageGet();
        
    }
}
