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
