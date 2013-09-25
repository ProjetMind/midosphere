<?php

namespace Mind\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RechercheController extends Controller
{
    public function indexAction()
    {
        return $this->render('::layout.html.twig', array('name'     => 'Diallo'));
    }
}
