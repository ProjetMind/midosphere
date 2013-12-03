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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

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
            'form'          => $form->createView()
        ));
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $serviceAcl = $this->container->get('mind_site.acl_security');
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $pathAvatar = $this->checkPathProfileAvatar($user->getSexe());
        $user->setPath($pathAvatar);
        $this->createAvatar($user->getId(), $user->getPath());
        
        $this->container->get('fos_user.user_manager')->updateUser($user);

        //Acl
        $tabAcl = array();
        $tabAcl[] = $user;
        $serviceAcl->updateAcl($tabAcl);
        
        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:confirmed.html.'.$this->getEngine(), array(
            'user' => $user,
        ));
    }
    
    /**
     * 
     * Permet de mettre un lien avatar par défaut pour le nouveau user
     * 
     * @param type $user
     */
    public function checkPathProfileAvatar($sexe){
        
        $pathAvatar = "img/";
        
        //Check path of profile image
        if($sexe == 1){

            $pathAvatar = $pathAvatar.'avatar-homme.jpeg';
        }else{
            $pathAvatar = $pathAvatar.'avatar-femme.jpeg';
        }
        
        return $pathAvatar;
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
