<?php

namespace Mind\MpBundle\Doctrine\Manager;

use Mind\MpBundle\Doctrine\Manager\BaseManager;

class MessageManager extends BaseManager {
    
    public function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine, \Mind\SiteBundle\DateFormatage $dateFormatage, \Symfony\Component\Security\Core\SecurityContext $securityContext, \Symfony\Component\DependencyInjection\ContainerInterface $container, \Symfony\Component\Form\FormFactory $form) {
        parent::__construct($doctrine, $dateFormatage, $securityContext, $container, $form);
    }

    /**
     * 
     * @param \Mind\MpBundle\Entity\Message $message
     * @return \Mind\MpBundle\Entity\Message
     */
    public function createMessageGet(\Mind\MpBundle\Entity\Message $message = null){
        
        if($message == null){
            $message = new \Mind\MpBundle\Entity\Message;
        }
        
        $idExpediteur   = $this->security->getToken()->getUser()->getId();
        $message->setIdExpediteur($idExpediteur);

        return $message;
    }
        
}
