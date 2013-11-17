<?php

namespace Mind\RechercheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RechercheController extends Controller
{
    public function indexAction()
    {
        $template = "MindRechercheBundle:Recherche:recherche.html.twig";
        return $this->container->get('templating')->renderResponse($template,
                array(
                        
                     ));
    }
}
