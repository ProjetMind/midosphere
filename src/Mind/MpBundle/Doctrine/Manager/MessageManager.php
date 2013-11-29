<?php

namespace Mind\MpBundle\Doctrine\Manager;

use Mind\MpBundle\Doctrine\Manager\BaseManager;

class MessageManager extends BaseManager {
    
    public function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine, \Mind\SiteBundle\DateFormatage $dateFormatage, \Symfony\Component\Security\Core\SecurityContext $securityContext, \Symfony\Component\DependencyInjection\ContainerInterface $container, \Symfony\Component\Form\FormFactory $form) {
        parent::__construct($doctrine, $dateFormatage, $securityContext, $container, $form);
    }

    /**
     * 
     * Créer une entity message si le parametre $message n'est pas nul
     * et en modifie l'id expéditeur
     * 
     * @param \Mind\MpBundle\Entity\Message|null $message
     * @return \Mind\MpBundle\Entity\Message
     */
    public function createMessageGet(\Mind\MpBundle\Entity\Conversation $conversation, 
                                     \Mind\MpBundle\Entity\Message $message = null){
        
        if($message == null){
            $message = new \Mind\MpBundle\Entity\Message;
        }
        
        $idExpediteur   = $this->security->getToken()->getUser()->getId();
        $message->setIdExpediteur($idExpediteur);
        $message->setIdConversation($conversation->getId());

        return $message;
    }
    
    /**
     * 
     * Recupère le dernier message d'une conversation
     * 
     * @param type $idConversation
     * @return \Mind\MpBundle\Entity\Message
     */
    public function getLastMessageForConversation($idConversation){
        
        $repo           = $this->manager->getRepository('MindMpBundle:Message');
        $lastMessage    = $repo->getLastMessageForConversation($idConversation);
        
        return $lastMessage;
        
    }
        
    /**
     * 
     * Rècupère et retourne la liste des messages, l'auteur et la date pour une conversation 
     * 
     * @param integer $idConversation
     * @return collectionMessage
     */
    public function getMessagesByIdConversation($idConversation){
        
        $repo           = $this->manager->getRepository('MindMpBundle:Message');
        $repoUser       = $this->manager->getRepository('MindUserBundle:User');
        $optionsSearch  = array(
            'idConversation'    => $idConversation
        );
        $tabMessage = array();
        
        $messages = $repo->findBy($optionsSearch);
        
        foreach ($messages as $message){
            
            $user = $repoUser->findOneBy(array('id' => $message->getIdExpediteur()));
            $tabMessage[] = array(
                'message'      => $message,
                'auteur'        => $user
            );
        }
        
        return $tabMessage;
        
    }
}
