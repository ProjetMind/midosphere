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
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends BaseController
{
    
    
    public function loginAction()
    {
        if($this->container->get('security.context')->isGranted('ROLE_USER')){
        
            $route  = "mind_site_homepage";
            $url    = $this->container->get('router')->generate($route);
            return new RedirectResponse($url);
        }
        
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
        ));
    }
    
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
