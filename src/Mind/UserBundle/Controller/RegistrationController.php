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

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends BaseController
{
    
    public function registerAction()
    {
        
        if($this->container->get('security.context')->isGranted('ROLE_USER')){
        
            $route  = "mind_site_homepage";
            $url    = $this->container->get('router')->generate($route);
            return new RedirectResponse($url);
        }
        
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }

            return $response;
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }

    
    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        $serviceAcl = $this->container->get('mind_site.acl_security');
        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());
        
        $user = $this->checkPathProfileAvatar($user);
        $this->createAvatar($user->getId(), $user->getPath());

        $this->container->get('fos_user.user_manager')->updateUser($user);
        
        //Acl
        $tabAcl = array();
        $tabAcl[] = $user;
        $serviceAcl->updateAcl($tabAcl);
        
        $response = new RedirectResponse($this->container->get('router')->generate('fos_user_registration_confirmed'));
        $this->authenticateUser($user, $response);

        return $response;
    }
    
    /**
     * 
     * Permet de mettre un lien avatar par défaut pour le nouveau user
     * 
     * @param type $user
     */
    public function checkPathProfileAvatar($user){
        
        $pathAvatar = "../web/img/";
        
        //Check path of profile image
        if($user->getSexe() == 1){

            $user->setPath($pathAvatar.'avatar-homme.jpeg');
        }else{
            $user->setPath($pathAvatar.'avatar-femme.jpeg');
        }
        
        return $user;
    }
    
    /**
     * 
     * Créer une entité avatar pour le user
     * 
     * @param integer $idUser
     * @param string $path
     */
    public function createAvatar($idUser, $path){
        
        $serviceAcl = $this->container->get('mind_site.acl_security');
        $avatar = new \Mind\MediaBundle\Entity\Avatar();
        
        $avatar->setIdUser($idUser);
        $avatar->setPath($path);
        $this->container->get('doctrine')->getManager()->persist($avatar);
        $this->container->get('doctrine')->getManager()->flush();
        
        //Acl
        $tabAcl = array();
        $tabAcl[] = $avatar;
        $serviceAcl->updateAcl($tabAcl);
        
    }

}
