<?php

namespace Mind\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MenuController extends Controller
{

    public function getMenuGAccueilAction(){
        
        return $this->render('::menuGauche.html.twig'
                );

    }
    
    public function getMenuDAccueilAction(){
        return $this->render('::menuDroit.html.twig');
    }
   
}
