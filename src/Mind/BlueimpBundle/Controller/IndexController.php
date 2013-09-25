<?php

namespace Mind\BlueimpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $uploadHandler = $this->container->get('mind_blueimp.uploadhandler');
        return $this->render('');
    }
}
