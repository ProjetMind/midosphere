<?php

namespace Mind\MpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Mind\MpBundle\Form\Type\MessageType;
use Mind\MpBundle\Form\Type\ConversationType;
use Mind\MpBundle\Form\Type\LectureType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * 
 */
class MessagerieController extends Controller {
    
    /**
     * 
     * Fonction pour la page d'accueil de la messagerie et la boite au lettre
     * 
     * @return Symfony\Component\HttpFoundation\Response
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction(){
        
        $conversationservice                = $this->container->get('mind_mp.conversation');
        $tabForConversationType             = $conversationservice->getConversationForConversationType('bal');
        $template                           = 'MindMpBundle:BAL:bal.html.twig';
        $conversation                       = new \Mind\MpBundle\Entity\Conversation();
        $form                               = $this->createForm(new ConversationType($tabForConversationType), $conversation);
        
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'form' => $form->createView()
                ));
    }
    
    /**
     * 
     * Page d'accueil des archives de la messagerie
     * 
     * @return type
     */
    public function indexArchiveAction(){
        
        $conversationservice                = $this->container->get('mind_mp.conversation');
        $tabForConversationType             = $conversationservice->getConversationForConversationType('archive');
        $template                           = 'MindMpBundle:Archives:archives.html.twig';
        $conversation                       = new \Mind\MpBundle\Entity\Conversation();
        $form                               = $this->createForm(new ConversationType($tabForConversationType), $conversation);
        
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'form' => $form->createView()
                ));
    }
    
    /**
     * 
     * Permet de supprimer une conversation.
     * A vrai dire, la conversation n'est pas supprimer, elle est juste désactivé pour le user
     * 
     * @return Response
     * @Secure(roles="ROLE_USER")
     */
    public function supprimerAction(){
        
        $serviceConversation    = $this->container->get('mind_mp.conversation');
        $tabConversation        = $this->getRequest()->get('mind_mpbundle_conversationtype')['id'];
        $serviceBootstrapFlash  = $this->container->get('bc_bootstrap.flash');
       
        if(!empty($tabConversation)){
            
            $serviceConversation->supprimerConversation($tabConversation);
            
            //message de confirmation 
            $messageDeConfirmation = "Conversation(s) supprimer avec succès.";
            $serviceBootstrapFlash->success($messageDeConfirmation);
            
        }else{
            
            //message d'e confirmation'erreur 
            $messageDeConfirmation = "Vous devez séléctionner au moins une conversation.";
            $serviceBootstrapFlash->info($messageDeConfirmation);
            
        }
        
        $url = $this->generateUrl('mind_mp_archive');
        return $this->redirect($url);
        
    }
    
    /**
     * 
     * Archive les conversations et redirige vers la page d'accueil de la messagerie
     * 
     * @return type
     * @Secure(roles="ROLE_USER")
     * 
     */
    public function archiverAction(){
        
        $serviceConversation    = $this->container->get('mind_mp.conversation');
        $tabConversation        = $this->getRequest()->get('mind_mpbundle_conversationtype')['id'];
        $serviceBootstrapFlash  = $this->container->get('bc_bootstrap.flash');
        
        if(!empty($tabConversation)){
            
            $serviceConversation->archiverConversation($tabConversation);

            //message de confirmation 
            $messageDeConfirmation = "Conversation(s) archiver avec succès.";
            $serviceBootstrapFlash->success($messageDeConfirmation);
            
        }else{
            
            //message d'e confirmation'erreur 
            $messageDeConfirmation = "Vous devez séléctionner au moins une conversation.";
            $serviceBootstrapFlash->info($messageDeConfirmation);
        }
        
        $url = $this->generateUrl('mind_mp_homepage');
        return $this->redirect($url);
        
    }
    
    /**
     * 
     * Index de la page de lecture d'une conversation. 
     * 
     * @param integer $idConversation
     * @return Response
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function conversationAction($idConversation){
        
        $serviceConversation    = $this->container->get('mind_mp.conversation');
        $serviceAcl             = $this->container->get('mind_site.acl_security');
        //$serviceSecurity        = $this->container->get('mind_user.security');
        
        //$conversation           = $serviceConversation->findByIdUser($idConversation);
        
        //$serviceSecurity->notFound($conversation, "La conversation");
        $conversation = $serviceConversation->findById($idConversation);
        $serviceAcl->notFound($conversation);
        
        $arrayParticipants      = $serviceConversation->getArrayParticipantsForConversation($idConversation);
        
        $this->setLuAction($idConversation);
        
        $template = 'MindMpBundle:Conversation:conversation.html.twig';
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'idConversation'    => $idConversation,
                        'tabDestinataires'  => $arrayParticipants
                ));
    }
    
    /**
     * 
     * Permet de faire un nouveau message pour une conversation 
     * 
     * @param integer $idConversation
     * @return Response
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function nouveauMessageAction($idConversation){
        
        $message                = new \Mind\MpBundle\Entity\Message;
        $form                   = $this->createForm(new LectureType(), $message);
        $request                = $this->container->get('request');
        $serviceMessage         = $this->container->get('mind_mp.message');
        
        $tabMessage             = array();
        
        if($request->getMethod() === "POST"){
            
            $conversation = $this->getDoctrine()->getManager()->getRepository('MindMpBundle:Conversation')->find($idConversation);
            if(!empty($conversation)){
                $message = $serviceMessage->createMessageGet($conversation, $message);
                $message->setDestinataires(-1);
            }
            
            $form->bind($request);
            
            if($form->isValid()){
                
                $em = $this->container->get('doctrine')->getManager();
                $em->persist($message);
                $em->flush();
                
                $tabDest = $serviceMessage->getArrayParticipantForSetLu($idConversation);
                $serviceMessage->createLuGet($conversation, $message, $tabDest);
                
                $tabMessage[] = array(
                    'message'       => $message,
                    'auteur'        => $this->container->get('security.context')->getToken()->getUser()
                );
            }
        }
        
        $template = 'MindMpBundle:Message:un_message.html.twig';
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'messages'      => $tabMessage,
                        'formErrors'    => $form->getErrors()
                ));
        
    }
    
    /**
     * 
     * Retourne le formulaire de message pour la page de lecture d'une conversation
     * 
     * @Secure(roles="ROLE_USER")
     * @param integer $idConversation
     * @return Response
     */
    public function getFormMessageAction($idConversation){
     
        $serviceConversation    = $this->container->get('mind_mp.conversation');
        $message                = new \Mind\MpBundle\Entity\Message;
        $form                   = $this->createForm(new LectureType(), $message);
        
        $template = 'MindMpBundle:Forms/Message:form_message.html.twig';
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'form'              => $form->createView(),
                        'idConversation'    => $idConversation
                ));
        
    }
    
    /**
     * 
     * Fournit la liste des messages d'une conversation et l'auteur du messages
     * 
     * @param integer $idConversation
     * @return Response
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function getMessagesAction($idConversation){
        
        $serviceMessage         = $this->container->get('mind_mp.message');
        $messages               = $serviceMessage->getMessagesByIdConversation($idConversation);
        
        $template = 'MindMpBundle:Message:un_message.html.twig';
        
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'messages'      => $messages
                ));
    }
    
    /**
     * 
     * Créer une nouvelle conversation avec :
     *  - Entité participants
     *  - Entité Lu
     *  - Entité Dossier 
     * 
     * @Secure(roles="ROLE_USER")
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function nouvelleConversationAction(){
        
        $messageManager         = $this->container->get('mind_mp.message');
        $conversationManager    = $this->container->get('mind_mp.conversation');
        $message                = new \Mind\MpBundle\Entity\Message;
        $form                   = $this->createForm(new MessageType(), $message);
        $em                     = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
       
        if($request->getMethod() === "POST"){
            
            $tabDest = $this->getRequest()->get('mind_mpbundle_messagetype');
            if(isset($tabDest['destinataires'])){
                $tabDest = $tabDest['destinataires'];
            }
            
            $conversation   = $conversationManager->createConversationGet();
            $em->persist($conversation);
            $em->flush();
            
            $message = $messageManager->createMessageGet($conversation, $message);
            
            $form->bind($request);
            
            if($form->isValid()){
                
                $em->persist($message);
                $em->flush();
                
                $tabPart        = $messageManager->createParticipantsGet($conversation, $tabDest);
                $tabLu          = $messageManager->createLuGet($conversation, $message, $tabDest);
                $tabDossier     = $messageManager->createDossierGet($conversation, $tabDest);
                
                $em->flush();
                
                //Acl 
                $serviceAcl = $this->container->get('mind_site.acl_security');
                $tabAcl     = array();
                $tabAcl[]   = $conversation;
                $tabAcl[]   = $message;
                $serviceAcl->updateAcl($tabAcl);
                
                //Redirection vers la conversation
                return $this->redirect($this->generateUrl('mind_mp_conversation', array(
                    'idConversation'        => $conversation->getId()
                )));
                
            }else{
                $em->remove($conversation);
                $em->flush();
            }
        }
        
        $template = 'MindMpBundle:Forms/Conversation:form_nouvelle_conversation.html.twig';
        return $this->container->get('templating')->renderresponse($template,
                array(
                        'form'      => $form->createView()
                ));
    }
    
    /**
     * 
     * Construit la liste des utilisateurs username et id pour l'envoi de msg
     * C'est la liste des destinataires
     * 
     * @Secure(roles="ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
    
    /**
     * 
     * Recupère le dernier message d'une conversation
     * 
     * @param type $idConversation
     * @return \Symfony\Component\HttpFoundation\Response
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function  getLastMessageForConversationAction($idConversation){
        
        $serviceMessage = $this->container->get('mind_mp.message');
        $lastMessage    = $serviceMessage->getLastMessageForConversation($idConversation);
        $message        = $lastMessage->getContenuMessage();
        
        return new Response(substr($message, 0, 40).'...');
    }
    
    public function setLuAction($idConversation){
    
        $serviceConversation = $this->container->get('mind_mp.conversation');
        $serviceConversation->setLu($idConversation);
        
        return new Response();
    }
    
    /**
     * 
     * Permet de savoir si un message est lu ou non par un user
     * 
     * @param integer $idConversation
     * @param integer $idUser|null
     * 
     * @return Response 
     */
    public function isLuAction($idConversation, $idUser = null){
        
        if($idUser == NULL){
            $idUser = $this->getUser()->getId();
        }
        
        $serviceMessagerie = $this->container->get('mind_mp.message');
        $lu = $serviceMessagerie->findByLu($idConversation, $idUser);
        
        $template = 'MindMpBundle:Others:lu.html.twig';
        
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'lu'    => $lu
                ));
    }
    
    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function getNbConversationNonLuAction(){
        
        $idUser = $this->getUser()->getId();
        $serviceConversation    = $this->container->get('mind_mp.conversation');
        $nbConversation         = $serviceConversation->findNbConversationNonLu($idUser);
        
        $nb = array(
            'nb'    => $nbConversation[0][1]
        );
        
        $response = new Response(json_encode($nb));
        $response ->headers->set('Content-Type', 'application/json');
        
        return $response;
    }


    /**
     * 
     * 
     * @return Response 
     */
    public function indexNotificationAction(){
        
        $serviceConversation = $this->container->get('mind_mp.conversation');
        $conversations = $serviceConversation->getConversationsUserCourant();
        
        $template = 'MindMpBundle:Notification:notification.html.twig';
        
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'conversations'         => $conversations
                ));
    }
}
