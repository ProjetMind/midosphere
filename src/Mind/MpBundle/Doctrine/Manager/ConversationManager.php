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
     * Construit un tableau de participant pour l'entité conversation
     * 
     * @return array
     */
    public function getConversationForConversationType(){
        
        $idUserCourant      = $this->security->getToken()->getUser()->getId();
        
        $tabConversation    = array();
        $repo               = $this->manager->getRepository('MindMpBundle:Conversation');
        $conversations      = $repo->getConversationForConversationType($idUserCourant);
        
        foreach ($conversations as $conversation){
            
            $users = $this->getListeUserForConversation($conversation->getId());
            $htmlParticipantsUsername = '';
            
            foreach ($users as $user){
                $htmlParticipantsUsername .= $user->getUsername().'   ';
            }
            $tabConversation[$conversation->getId()] = $htmlParticipantsUsername;
        }
        
        return $tabConversation;
    }
    
    public function getListeUserForConversation($idConversation){
        
        $arraySearch = array('idConversation'   => $idConversation);
        $repo = $this->manager->getRepository('MindMpBundle:Participants');
        $participants = $repo->findBy($arraySearch);
        $tabUser = array();
        
        foreach ($participants as $participant){
            $tabUser[] = $this->manager->getRepository('MindUserBundle:User')->find($participant->getIdUser());
        }
        
        return $tabUser;
    }
    
    /**
     * 
     * Créer une entity conversation si le parametre $conversation n'est pas nul
     * et en modifie l'id auteur
     * 
     * @param \Mind\MpBundle\Entity\Conversation|null $conversation
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
