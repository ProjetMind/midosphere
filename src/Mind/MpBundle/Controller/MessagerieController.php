<?php

namespace Mind\MpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mind\MpBundle\Form\Type\MessageType;

class MessagerieController extends Controller {
    
    public function indexAction(){
        
        $template = 'MindMpBundle::layout.html.twig';
        return $this->container->get('templating')->renderResponse($template,
                array());
        
    }
    
    public function conversationAction($idConversation){
        
    }
    
    public function nouvelleConversationAction(){
        
        $messageManager         = $this->container->get('mind_mp.message');
        $conversationManager    = $this->container->get('mind_mp.conversation');
        $message                = new \Mind\MpBundle\Entity\Message;
        $form                   = $this->createForm(new MessageType(), $message);
        $em                     = $this->getDoctrine()->getManager();
        $em->clear();
       
        
        $request = $this->getRequest();
       
        if($request->getMethod() === "POST"){
            
            $tabDest = $_POST['mind_mpbundle_messagetype']['destinataires'];
            $form->bind($request);
            
            if($form->isValid()){
                
                $conversation   = $conversationManager->createConversationGet();
                $em->persist($conversation);
                $em->flush();
                
                $message        = $messageManager->createMessageGet($message);
                $message->setIdConversation($conversation->getId());
                $em->persist($message);
                
                $em->flush();
                
                $tabPart        = $messageManager->createParticipantsGet($conversation, $tabDest);
                $tabLu          = $messageManager->createLuGet($conversation, $message, $tabDest);
                
                $em->flush();
                
                //Redirection vers la conversation
                return $this->redirect($this->generateUrl('mind_mp_conversation', array(
                    'idConversation'        => $conversation->getId()
                )));
                
            }
        }
        
        $template = 'MindMpBundle:Forms/Conversation:form_nouvelle_conversation.html.twig';
        return $this->container->get('templating')->renderresponse($template,
                array(
                        'form'      => $form->createView()
                ));
    }
    
    public function getArrayObjectUserAction(){
        
        $terms = $this->getRequest()->get('searchTerms');
        
        $users = $this->getDoctrine()
                         ->getManager()
                         ->getRepository('MindMpBundle:Conversation')
                         ->getAutocompleteResult($terms);
        
        $tabResult = array();
        
        foreach ($users as $unUser){
            
            $tabResult[] = array(
                                    "username" => $unUser->getUsername(),
                                    "id"       => $unUser->getId()
                                ); 
        }
        
        $response = new Response(json_encode($tabResult));
        $response ->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
