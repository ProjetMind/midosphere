<?php

namespace Mind\MpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\MpBundle\Form\Type\ConversationType;
use Mind\MpBundle\Entity\Conversation;
use Symfony\Component\HttpFoundation\Response;

class ConversationController extends Controller
{
    
    public function supprimerConversationAction(){
    
        $tabIdConversation =  $this->getRequest()->get('toAction');
        $messagerieService = $this->get('mind_mp.messagerie');
        $idUserCourant = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
       
        foreach ($tabIdConversation as $idConversation){
            
            $conversation       = $messagerieService->getConversations('archive', $idConversation);
            $tabConversation    = $conversation[0]->getTabParticipants();
            $em->remove($conversation[0]);
            
            foreach ($tabConversation as $key => $idConversationValue) {
            
                if($idConversationValue == $idUserCourant)
                {
                    unset($tabConversation[$key]);
                    $tabConversation = array_merge($tabConversation);
                }
            }
            
            $conversation[0]->setTabParticipants($tabConversation);
            $em->persist($conversation[0]);
            
        }
        
        $em->flush();
        
        $messages = "Conversation(s) supprimées avec succès";
        $this->get('session')->getFlashBag()->add('success', $messages);
        
        $url = $this->generateUrl('mind_message_archive');
        
        return $this->redirect($url);
    }
    
    public function archiverConversationAction(){
        
        $tabIdConversation =$this->getRequest()->get('toAction');
        $messagerieService = $this->get('mind_mp.messagerie');
        $em = $this->getDoctrine()->getManager();
        
        foreach ($tabIdConversation as $idConversation){
            
            $conversation = $messagerieService->getConversations('bal', $idConversation);
            $conversation[0]->setDossier('archive');
            
            $em->persist($conversation[0]);
        }
        
        $em->flush();
        
        $messages = "Conversation(s) archiver avec succès";
        $this->get('session')->getFlashBag()->add('success', $messages);
        
        $url = $this->generateUrl('mind_message_homepage');
        
        return $this->redirect($url);
    }


    public function nouvelleConversationAction(){
        
        $conversation = new Conversation();
        $form = $this->createForm(new ConversationType(), $conversation);
        
        $request = $this->container->get('request');
        
        if($request->getMethod() == "POST"){
            
            $form->bind($request);
            
            //Modifier l'entite
            
            $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
            $tabParticipants = $conversation->getTabParticipants();
            $tabParticipants[] = $idAuteur;
            
            $conversation->setAuteurConversation($idAuteur);
            $conversation->setTabParticipants($tabParticipants);
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($conversation);
                $em->flush();
                
                //Message and Participant
                $message        = new \Mind\MpBundle\Entity\Message;
                
                //Variables
                $contenuMessage = $_POST['message'];
                $idConversation = $conversation->getId();
                
                //Set
                $message->setIdExpediteur($idAuteur);
                $message->setContenuMessage($contenuMessage);
                $message->setIdConversation($idConversation);
                
                //Save
                $em->persist($message);
                $em->flush();
                
                //Redirection vers la conversation
                return $this->redirect($this->generateUrl('mind_message_conversation', array(
                    'idConversation'        => $idConversation
                )));
                
            }
        }
        
        $template = sprintf('MindMpBundle:Conversation:conversation.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'form'      => $form->createView()
                ));
    }
    
    public function getArrayObjectUserAction($terms){
        
        $users = $this->getDoctrine()
                         ->getManager()
                         ->getRepository('MindMpBundle:Conversation')
                         ->getAutocompleteResult($terms);
        
        $tabResult = array();
        
        foreach ($users as $unUser){
            
            $tabResult[] = array(
                                    "label"        => '<strong>'.$unUser->getUsername().'</strong>',
                                    "value"        => $unUser->getUsername(),
                                    "idUser"       => $unUser->getId()
                                ); 
        }
        
        $response = new Response(json_encode($tabResult));
        $response ->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
