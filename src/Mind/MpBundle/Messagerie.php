<?php

namespace Mind\MpBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Routing\Router;
use Mind\SiteBundle\DateFormatage;
use Symfony\Component\Security\Core\SecurityContext;

class Messagerie {
    
    protected $doctrine;
    protected $manager;
    protected $router;
    protected $dateFormatage;
    protected $securityContext;
    protected $idUserCourant;


    public function __construct(Registry $doctrine, Router $router, DateFormatage $dateFormatage, SecurityContext $securityContext) {
        
        $this->doctrine         = $doctrine;
        $this->router           = $router;
        $this->manager          = $doctrine->getManager();
        $this->dateFormatage    = $dateFormatage;
        $this->securityContext  = $securityContext;
        $this->idUserCourant    = $securityContext->getToken()->getUser()->getId();
        
    }
    
    public function getConversations($dossier, $idConversation = null){
        
        //dossier = archive ou bal 
        if($idConversation == null){
            
            $conversation = $this->manager->getRepository('MindMpBundle:Conversation')
                                           ->getConversations($this->idUserCourant, $dossier);
            
        }
        else{
            $conversation = $this->manager->getRepository('MindMpBundle:Conversation')
                                            ->getConversations($this->idUserCourant, $dossier, $idConversation);
        }
        
        return $conversation;
        
    }

    public function getAuteurs($idAuteur){
      
      
        $tabAuteur = array();
        $infosAuteur = array();
        $user = $this->manager->getRepository('MindUserBundle:User')->find($idAuteur);
        
        $slugAuteur = $user->getSlug();
        $pathProfileAuteur = $this->router->generate('mind_user_profile_voir', array('slug'  => $slugAuteur));
        $linkProfileAuteur = '<a href="'.$pathProfileAuteur.'"  title="'.$slugAuteur.'">%s</a>';

        $infosAuteur['pseudo'] = $user->getUsername();
        $infosAuteur['id']  = $idAuteur;
        $infosAuteur['profileLink'] = sprintf($linkProfileAuteur, $infosAuteur['pseudo']);
        $infosAuteur['slug'] = $slugAuteur;

        return $infosAuteur;
        
    }
    
    public function getParticipants($dossier, $idConversation = null){
        
        $conversations = $this->getConversations($dossier, $idConversation);
        
        $tabUserParticipants = array();
        
        foreach ($conversations as $uneConversation){
            
            $idConversation = $uneConversation->getId();
            $tabParticipants = $uneConversation->getTabParticipants();
            
            foreach ($tabParticipants as $unParticipant){
                $tabUserParticipants[$idConversation][$unParticipant] = $this->getAuteurs($unParticipant);
            }
            
        }
        
        return $tabUserParticipants;
    }
    
    public function getDate($dossier, $dateFor){
        
        $dateFormatage = array();
        
        switch ($dateFor){
            
            case 'conversation':
                    $dateFormatage = $this->getDateConversation($dossier);
                break;
            
            case 'message':
                $dateFormatage = $this->getDateMessage($dossier);
                break;
        }
        
        return $dateFormatage;
    }
    
    protected function getDateMessage($dossier, $idConversation =  null){
        
        $repositoryMessage = $this->manager->getRepository('MindMpBundle:Message');
    }
    
    protected function getDateConversation($dossier, $idConversation = null){
     
        $repositoryConversation = $this->manager->getRepository('MindMpBundle:Conversation');
        $tabDateConversation = array();
        
        $conversations = $this->getConversations($dossier, $idConversation);
        
        foreach ($conversations as $uneConversation){
            
            $idConversationCourante = $uneConversation->getId();
            $dateCreateConversation = $uneConversation->getDateDebutConversation();
            $tabDateConversation[$idConversationCourante] = $this->dateFormatage->getDate($dateCreateConversation);
        }
        
        return $tabDateConversation;
    }
    
    public function getMessage($idConversation = null){
        
        $repositoryMessage      = $this->manager->getRepository('MindMpBundle:Message');
        $conversations          = $this->getConversations('bal', $idConversation);
        $tabMessage             = array();
        
        foreach ($conversations as $conversation){
            
            $idConversationCourante = $conversation->getId();
            $messages = $repositoryMessage->getMessageByIdConversation($idConversationCourante);
            
            foreach ($messages as $message){
                $tabMessage[$idConversationCourante][$message->getId()] = $this->getMessageForConversation($message); ;
            }
            
            
        }
        
        return $tabMessage;
    }
    
    protected function getMessageForConversation($message){
        
        $tabMessage             = array();
            
        $idAuteur       = $message->getIdExpediteur();
        $dateSendMsg    = $message->getDateEnvoiMessage();

        $tabMessage['id']          = $message->getId();
        $tabMessage['message']     = $message->getContenuMessage();
        $tabMessage['auteur']      = $this->getAuteurs($idAuteur);
        $tabMessage['dateEnvoi']   = $this->dateFormatage->getDate($dateSendMsg);
        
        
        return $tabMessage;
        
    }
}
