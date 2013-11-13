<?php

namespace Mind\MpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MessagerieController extends Controller {
    
    public function indexAction(){
        
        $template = 'MindMpBundle::layout.html.twig';
        return $this->container->get('templating')->renderResponse($template,
                array());
        
    }
    
    public function nouvelleConversationAction(){
        
    }
}
