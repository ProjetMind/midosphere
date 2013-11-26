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
    protected $aclSecurity;

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
        $this->aclSecurity      = $this->container->get('mind_site.acl_security');
        
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
        $this->manager->persist($participant);
        $this->manager->flush();
        $tabParticipants[] = $participant;
        
        $tabAcl     = array();
        $tabAcl[]   = $participant;
        $this->aclSecurity->updateAcl($tabAcl);
        
        
        foreach ($tabIdParticipant as $unIdParticipant){
            
            if($idUserCourant != $unIdParticipant){
                
                $participant = new \Mind\MpBundle\Entity\Participants;
                $participant->setIdConversation($idConversation);
                $participant->setIdUser($unIdParticipant);
                $this->manager->persist($participant);
                $this->manager->flush();
                
                $user = $this->manager->getRepository('MindUserBundle:User')->find($participant->getIdUser());
                if(!empty($user)){
                    $tabAcl     = array();
                    $tabAcl[]   = $participant;
                    $this->aclSecurity->updateAcl($tabAcl, $user);
                }
                
                $tabParticipants[] = $participant;
                
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
        $this->manager->persist($lu);
        $this->manager->flush();
        $tabLu[] = $lu;
        
        //Acl
        $tabAcl = array();
        $tabAcl[] = $lu;
        $this->aclSecurity->updateAcl($tabAcl);
        
        foreach ($tabIdParticipant as $unIdParticipant){
            
            if($idUserCourant != $unIdParticipant){
                
                $lu = new \Mind\MpBundle\Entity\Lu();
                $lu->setIdConversation($idConversation);
                $lu->setIdMessage($idMessage);
                $lu->setIdUser($unIdParticipant);
                $this->manager->persist($lu);
                $this->manager->flush();
                
                $user = $this->manager->getRepository('MindUserBundle:User')->find($lu->getIdUser());
                
                if(!empty($user)){
                    //Acl
                    $tabAcl     = array();
                    $tabAcl[]   = $lu;
                    $this->aclSecurity->updateAcl($tabAcl);
                }
                $tabLu[] = $lu;
            }
        }
        
        return $tabLu;
    }
    
    /**
     * 
     * Met à jour une entité lu à true
     * 
     * @param integer $idConversation
     */
    public function setLu($idConversation){
        
        $repo = $this->manager->getRepository('MindMpBundle:Lu');
        $idUserCourant = $this->security->getToken()->getUser()->getId();
        $optionsSearch = array(
            'idConversation'    => $idConversation,
            'idUser'            => $idUserCourant
        );
        
        $lu = $repo->findOneBy($optionsSearch);
        if(!empty($lu)){
            $lu->setLu(true);
            $this->manager->persist($lu);
            $this->manager->flush();
        }
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
        $this->manager->flush();
        
        //Acl
        $tabAcl =array();
        $tabAcl[] = $dossier;
        $this->aclSecurity->updateAcl($tabAcl);
        
        $tabDossier[] = $dossier;
        
        foreach ($tadIdParticipant as $unIdParticipant){
            
            if($idUserCourant != $unIdParticipant){
                
                $dossier = new \Mind\MpBundle\Entity\Dossier;
                $dossier->setIdUser($unIdParticipant);
                $dossier->setIdConversation($idConversation);
                $dossier->setDossier('bal');
                $this->manager->persist($dossier);
                $this->manager->flush();
                
                $user = $this->manager->getRepository('MindUserBundle:User')->find($dossier->getIdUser());
                if(!empty($user)){
                    $tabAcl     = array();
                    $tabAcl[]   = $dossier;
                    $this->aclSecurity->updateAcl($tabAcl, $user);
                }
                $tabDossier[] = $dossier;
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
    
    /**
     * 
     * Vérifie si au moins un message n'a pas été lu par le user
     * @param integer $idConversation
     * @param integer $idUser
     * @return boolean 
     */
    public function findByLu($idConversation, $idUser){
        
        $repo = $this->manager->getRepository('MindMpBundle:Lu');
        $optionsSearch =    array(
            'idUser'            => $idUser,
            'idConversation'    => $idConversation,
            'lu'                => false
        );
        
        $lu = $repo->findBy($optionsSearch);
        
        if(empty($lu)){
            return true;
        }else{ 
            return false;
        }
    }
    
    public function findNbConversationNonLu($idUser){
        
        $repo = $this->manager->getRepository('MindMpBundle:Lu');
        $optionsSearch =    array(
            'idUser'            => $idUser,
            'lu'                => false
        );
        $nb = $repo->findNbConversationNonLu($optionsSearch);
        
        return $nb;
    }
    
    /**
     * 
     * Fournit la liste des participants en entité user pour une conversation
     * 
     * @param integer $idConversation
     * @return array
     */
    public function getParticipantsConversation($idConversation){
        
        $repo = $this->manager->getRepository('MindMpBundle:Participants');
        $repoUser = $this->manager->getRepository('MindUserBundle:User');
        $tabUser = array();
        $optionsSearch = array(
            'idConversation'    => $idConversation
        );
        
        $participants = $repo->findBy($optionsSearch);
        
        foreach ($participants as $participant){
            $tabUser[] = $repoUser->find($participant->getIdUser());
        }
        return $tabUser;
    }
}
