<?php

namespace Mind\MpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\MpBundle\Form\Type\MessageType;

class MessageController extends Controller
{
    
    public function indexAction()
    {
        $idUserCourant = $this->get('security.context')->getToken()->getUser()->getId();
        
        $messagerieService = $this->get('mind_mp.messagerie');
        
        $blocTitre       = 'Boite de récéption';
        $conversations  = $messagerieService->getConversations('bal');
        $participants   = $messagerieService->getParticipants('bal');
        $dates          = $messagerieService->getDate('bal', 'conversation');
        $messages       = $messagerieService->getMessage();
        $template       = sprintf('MindMpBundle:BAL:bal.html.twig');
        
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'conversations'         => $conversations,
                        'participants'          => $participants,
                        'dates'                 => $dates,
                        'messages'              => $messages,
                        'blocTitre'             => $blocTitre
                ));
    }
    
    public function archiveAction(){
        
        $idUserCourant = $this->get('security.context')->getToken()->getUser()->getId();
        $messagerieService = $this->get('mind_mp.messagerie');
        
        $blocTitre = "Archives";
        $conversations  = $messagerieService->getConversations('archive');
        $participants   = $messagerieService->getParticipants('archive');
        $dates          = $messagerieService->getDate('archive', 'conversation');
        $messages       = $messagerieService->getMessage();
        $template       = sprintf('MindMpBundle:Archives:archives.html.twig');
     
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'conversations'         => $conversations,
                        'participants'          => $participants,
                        'dates'                 => $dates,
                        'messages'              => $messages,
                        'blocTitre'             => $blocTitre
                ));
    }


    public function messageConversationAction($idConversation){
        
        $messagerieService = $this->get('mind_mp.messagerie');
        
        $conversations  = $messagerieService->getConversations($idConversation);
        $participants   = $messagerieService->getParticipants($idConversation);
        $dates          = $messagerieService->getDate('conversation');
        $messages       = $messagerieService->getMessage($conversations);
        
        $message = new \Mind\MpBundle\Entity\Message;
        $form = $this->createForm(new MessageType());
        
        $template = sprintf('MindMpBundle:Message:message.html.twig');
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'form'                  => $form->createView(),
                        'conversations'         => $conversations,
                        'participants'          => $participants,
                        'dates'                 => $dates,
                        'messages'              => $messages,
                        
                ));
    }
    
    public function nouveauMessageAction($idConversation){
        
        $message            = new \Mind\MpBundle\Entity\Message;
        $form               = $this->createForm(new MessageType(), $message);
        $messagerieService  = $this->get('mind_mp.messagerie');
        $template           = sprintf('MindMpBundle:Forms:form_message.html.twig');
        
        $request = $this->getRequest();
        
        if($request->getMethod() == "POST"){
            
            $form->bindRequest($request);
            
            //Modification de l'entité message
            $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
            
            $message->setIdExpediteur($idAuteur);
            $message->setIdConversation($idConversation);
            
            if($form->isValid()){
                
                $em     =   $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
                
                $messages       = $messagerieService->getMessage($idConversation);
                
                $template   = sprintf('MindMpBundle:Message:un_message.html.twig');
            }
        }
        
        
        return $this->container->get('templating')->renderResponse($template,
                        array(
                                'form'                 => $form->createView(),
                                'messageAdd'           => $messages[$idConversation][$message->getId()]
                             ));
        
    }
}
