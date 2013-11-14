<?php

namespace Mind\MpBundle\Doctrine\Manager;

use Mind\MpBundle\Doctrine\Manager\BaseManager;
use Mind\MpBundle\Entity\Conversation;

class ConversationManager extends BaseManager {    
    
    public function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine, \Mind\SiteBundle\DateFormatage $dateFormatage, \Symfony\Component\Security\Core\SecurityContext $securityContext, \Symfony\Component\DependencyInjection\ContainerInterface $container, \Symfony\Component\Form\FormFactory $form) {
        parent::__construct($doctrine, $dateFormatage, $securityContext, $container, $form);
    }

    /**
     * 
     * @param \Mind\MpBundle\Entity\Conversation $conversation
     * @return \Mind\MpBundle\Entity\Conversation
     */
    public function createConversationGet(\Mind\MpBundle\Entity\Conversation $conversation = null){
        
        if($conversation == null){
            $conversation = new Conversation(); 
        }
        
        $auteurConv     = $this->security->getToken()->getUser()->getId();
        $conversation->setAuteurConversation($auteurConv);
            
        return $conversation;
            
    }
    
}
