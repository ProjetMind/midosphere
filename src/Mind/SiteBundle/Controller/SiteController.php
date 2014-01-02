<?php

namespace Mind\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;

class SiteController extends Controller
{
    public function indexAction()
    {
        return $this->render('::layout.html.twig');
    }

    public function getNbFollowsAction(){
        
        $serviceTwitterApi = $this->container->get('mind_user.twitter_api');
        return new Response($serviceTwitterApi->getNbFollows());
    }
    
}

