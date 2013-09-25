<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mind\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    
    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        //$patternConnexion = 'fos_user_security_login';
        
        //On récupère la route :connexion si ce dernier existe
        $tabRouteConnexion = $this->container->get('request')->getUri();
        $pageOn = strpos($tabRouteConnexion, '/connexion');
        
        if($pageOn != false){
            
            $template = sprintf('MindUserBundle:Security:loginBody.html.%s', $this->container->getParameter('fos_user.template.engine'));
        }
        else
        {
         //$pattern = $tabRouteConnexion['_route']; 
            
            $template = sprintf('FOSUserBundle:Security:login.html.%s', $this->container->getParameter('fos_user.template.engine'));
        }
        
        return $this->container->get('templating')->renderResponse($template, $data);
    }
}
