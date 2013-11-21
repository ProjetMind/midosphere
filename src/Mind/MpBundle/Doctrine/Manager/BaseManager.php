<?php

namespace Mind\MpBundle\Doctrine\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Mind\SiteBundle\DateFormatage;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;


class BaseManager {
    
    protected $doctrine;
    protected $manager;
    protected $dateFormatage;
    protected $security;
    protected $container;
    protected $form;

    /**
     * 
     * @param \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
     * @param \Mind\SiteBundle\DateFormatage $dateFormatage
     * @param \Symfony\Component\Security\Core\SecurityContext $securityContext
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param \Symfony\Component\Form\FormFactory $form
     */
    public function __construct(Registry $doctrine, DateFormatage $dateFormatage, SecurityContext $securityContext,
                                ContainerInterface $container, FormFactory $form) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->dateFormatage    = $dateFormatage;
        $this->security         = $securityContext;
        $this->container        = $container;
        $this->form             = $form;
        
    }
    
    /**
     * 
     * Créer la liste des participants pour une conversation données
     * 
     * @param \Mind\MpBundle\Entity\Conversation $conversation
     * @param array $tabIdParticipant
     * @return array
     */
    public function createParticipantsGet(\Mind\MpBundle\Entity\Conversation $conversation, array $tabIdParticipant){
        
        $tabParticipants    = array();
        $idConversation     = $conversation->getId();
        $idUserCourant       = $this->security->getToken()->getUser()->getId();
        
        //Pour le user courant 
        $participant = new \Mind\MpBundle\Entity\Participants;
        $participant->setIdConversation($idConversation);
        $participant->setIdUser($idUserCourant);
        $tabParticipants[] = $this->manager->persist($participant);
        
        
        foreach ($tabIdParticipant as $unIdParticipant){
            
            if($idUserCourant != $unIdParticipant){
                
                $participant = new \Mind\MpBundle\Entity\Participants;
                $participant->setIdConversation($idConversation);
                $participant->setIdUser($unIdParticipant);

                $tabParticipants[] = $this->manager->persist($participant);
                
            }
        }
        
        return $tabParticipants;
    }
    
    /**
     * 
     * Créer une liste d'entity Lu pour une conversation et message données
     * 
     * @param \Mind\MpBundle\Entity\Conversation $conversation
     * @param \Mind\MpBundle\Entity\Message $message
     * @param array $tabIdParticipant
     * @return array
     */
    public function createLuGet(\Mind\MpBundle\Entity\Conversation $conversation,
                                \Mind\MpBundle\Entity\Message $message,
                                array $tabIdParticipant ){
        
        $tabLu              = array();
        $idConversation     = $conversation->getId();
        $idMessage          = $message->getId();
        $idUserCourant      = $this->security->getToken()->getUser()->getId();
        
        //Pour le user courant 
        $lu = new \Mind\MpBundle\Entity\Lu();
        $lu->setIdConversation($idConversation);
        $lu->setIdMessage($idMessage);
        $lu->setIdUser($idUserCourant);
        $lu->setLu(true);
        
        $tabLu[] = $this->manager->persist($lu);
        
        foreach ($tabIdParticipant as $unIdParticipant){
            
            if($idUserCourant != $unIdParticipant){
                
                $lu = new \Mind\MpBundle\Entity\Lu();
                $lu->setIdConversation($idConversation);
                $lu->setIdMessage($idMessage);
                $lu->setIdUser($unIdParticipant);

                $tabLu[] = $this->manager->persist($lu);
                
            }
        }
        
        return $tabLu;
    }
    
    /**
     * 
     * Créer une liste d'entity Dossier pour une conversation 
     * 
     * @param \Mind\MpBundle\Entity\Conversation $conversation
     * @param array $tadIdParticipant
     * @return array
     */
    public function createDossierGet(\Mind\MpBundle\Entity\Conversation $conversation,
                                     array $tadIdParticipant){
        
        $tabDossier = array();
        $idConversation     = $conversation->getId();
        $idUserCourant      = $this->security->getToken()->getUser()->getId();
        
        //Pour le user courant 
        $dossier = new \Mind\MpBundle\Entity\Dossier;
        $dossier->setIdUser($idUserCourant);
        $dossier->setIdConversation($idConversation);
        $dossier->setDossier('bal');
        
        $this->manager->persist($dossier);
        
        $tabDossier[] = $dossier;
        
        foreach ($tadIdParticipant as $unIdParticipant){
            
            if($idUserCourant != $unIdParticipant){
                
                $dossier = new \Mind\MpBundle\Entity\Dossier;
                $dossier->setIdUser($unIdParticipant);
                $dossier->setIdConversation($idConversation);
                $dossier->setDossier('bal');
                
                $tabDossier[] = $this->manager->persist($dossier);
            }
        }
        
        return $tabDossier;
    }
    
    public function getArrayParticipantsForConversation($idConversation){
        
        
        $conversation = $this->manager->getRepository('MindMpBundle:Conversation')->find($idConversation);
        $tabDest = array();
        
        if(!empty($conversation)){
            
            $optionSearch = array(
                'idConversation'    => $idConversation
            );
            $participants = $this->manager->getRepository('MindMpBundle:Participants')->findBy($optionSearch);
            
            foreach ($participants as $participant){
                
                $user = $this->manager->getRepository('MindUserBundle:User')->find($participant->getIdUser());
                $tabDest[$participant->getId()] = $user->getUsername();
            }
        }
        
        return $tabDest;
    }
}
