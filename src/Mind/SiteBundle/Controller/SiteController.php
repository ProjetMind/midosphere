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

    
}

