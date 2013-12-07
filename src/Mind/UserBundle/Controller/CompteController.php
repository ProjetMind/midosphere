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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\UserBundle\Form\InfosPersosCompteType;
use Mind\UserBundle\Form\InfosPersosLocalisationType;
use Mind\UserBundle\Form\ParametresConnexionType;
use Mind\MediaBundle\Form\Type\AvatarType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Cette classe gère les domaine :
 * - Ajout de domaine
 * - Modification 
 * - Suppression 
 * 
 * 
 */
class CompteController extends Controller
{
    
    public function indexAction(){
        //$up = new \Symfony\Component\HttpFoundation\File\UploadedFile($path, $originalName);
     
        $routeName = $this->getRequest()->get('_route');
        $template = sprintf('MindUserBundle:Compte:compte.html.twig');
       
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'routeName'   =>  $routeName
                     ));
    }
    
    public function getCompteAction(){
        
        $routeName = $this->getRequest()->get('_route');
        //$manager = $this->getDoctrine()->getManager();
        //$repositoryUser = $manager->getRepository('MindUserBundle:User');
        //$template = sprintf('MindUserBundle:Compte:un_compte.html.twig');
        
        $user = $this->container->get('security.context')->getToken()->getUser();
      
        switch ($routeName){
            
            case 'mind_user_compte':
                $template = sprintf('MindUserBundle:Compte:infos_persos_compte.html.twig');
                break;
            
            case 'mind_user_compte_infos_persos':
                $template = sprintf('MindUserBundle:Compte:infos_persos_compte.html.twig');
                break;
            
            case 'mind_user_compte_parametres':
                $template = sprintf('MindUserBundle:Compte:parametres_compte.html.twig');
                break;
        }
        
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'user'      => $user
                    ));
    }
    
    public function modifierAvatarAction(){
        
        $serviceAvatar = $this->container->get('mind_media.avatar');
        $serviceImage = $this->container->get('mind_media.upload_file');
        $listener = $this->container->get('gedmo.listener.uploadable');
        $serviceAcl = $this->container->get('mind_site.acl_security');
        $idUserCourant = $this->container->get('security.context')->getToken()->getUser()->getId();
        
        $avatar = new \Mind\MediaBundle\Entity\Avatar;
        $form = $this->createForm(new AvatarType(), $avatar);
        
        $request = $this->getRequest();
        
        if($request->getMethod() == 'POST'){
         
            $avatar->setIdUser($idUserCourant);
            
            $form->bind($request);
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getManager();
                
                //Avatar 
                $image = $serviceImage->createFileInfosAvatar($form->getData()->getFile());
                $fileInfos = new \Gedmo\Uploadable\FileInfo\FileInfoArray($image);
                $listener->addEntityFileInfo($avatar, $fileInfos);
                
                
                $em->persist($avatar); 
                $serviceAvatar->supprimerAvatar($idUserCourant);
                $em->flush();
                
                //Acl
                $tabAcl = array();
                $tabAcl[] = $avatar;
                $serviceAcl->createAcl($tabAcl);
                
                
                $serviceAvatar->updateUserPath($avatar->getPath());
                
                
                
            }
        }else{
            $avatar = $serviceAvatar->getAvatar($idUserCourant);
        }
        
        $template = sprintf('MindUserBundle:Compte\Forms:form_avatar.html.twig');
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'form'      => $form->createView(),
                        'avatar'    => $avatar
                     ));
    }
    
    public function modifierInfosPersosAction(){
        
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new InfosPersosCompteType(), $user);
        
        $request = $this->getRequest('request');
        
        if($request->getMethod() == 'POST'){
            
            $serviceAcl = $this->container->get('mind_site.acl_security');
            $serviceAcl->checkPermission('EDIT', $user);
            
            $form->bindRequest($request);
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                
                $messageDeConfirmation = "Les informations personnelles ont été mis à jours.";
                $template = sprintf('MindUserBundle:Compte:Infos\infos_persos.html.twig');
                return $this->container->get('templating')->renderResponse($template,
                        array(
                                'success'     => $messageDeConfirmation,
                                'user'        => $this->get('security.context')->getToken()->getUser()
                        ));
            }
        }
        
        $template = sprintf('MindUserBundle:Compte:Forms\form_infos_persos.html.twig');
        return $this->container->get('templating')->renderResponse($template, array('form'  => $form->createView()));
    }
    
    public function modifierLocalisationAction(){
        
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new InfosPersosLocalisationType(), $user);
        
        $request = $this->getRequest('request');
        
        if($request->getMethod() == 'POST'){
            
            $serviceAcl = $this->container->get('mind_site.acl_security');
            $serviceAcl->checkPermission('EDIT', $user);
            
            $form->bindRequest($request);
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                
                $messageDeConfirmation = "Les informations de localisation ont été mis à jour.";
                $template = sprintf('MindUserBundle:Compte:Infos\infos_persos_localisation.html.twig');
                return $this->container->get('templating')->renderResponse($template,
                        array(
                                'success'     => $messageDeConfirmation,
                                'user'        => $this->get('security.context')->getToken()->getUser()
                        ));
            }
        }
        
        $template = sprintf('MindUserBundle:Compte:Forms\form_infos_persos_localisation.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'form'  => $form->createView()
                    ));
        
    }
    
    public function modifierParametresConnexionAction(){
        
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new ParametresConnexionType(), $user);
        
        $lastEmail = $user->getEmail();
        
        $request = $this->getRequest('request');
        
        if($request->getMethod() == 'POST'){
        
            $serviceAcl = $this->container->get('mind_site.acl_security');
            $serviceAcl->checkPermission('EDIT', $user);
            
            $form->bindRequest($request);
        
            $emailInput = $form->get('email')->getData();
            if($emailInput == null){
                $user->setEmail($lastEmail);
               
            }
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                
                $messageDeConfirmation = "Les paramètres de connexion ont été mis à jour.";
                $template = sprintf('MindUserBundle:Compte:Infos\parametres_connexion.html.twig');
                return $this->container->get('templating')->renderResponse($template,
                        array(
                                'success'     => $messageDeConfirmation,
                                'user'        => $this->get('security.context')->getToken()->getUser()
                        ));
            }
        }
        
        $template = sprintf('MindUserBundle:Compte:Forms\form_parametres_connexion.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'form'  => $form->createView()
                    ));
        
    }
    
    public function getRenderInfosAction($idReplace){
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        switch ($idReplace){
            
            case 'informationsPersonelles':
                $template = sprintf('MindUserBundle:Compte:Infos\infos_persos.html.twig');
                break;
            
            case 'localisation':
                $template = sprintf('MindUserBundle:Compte:Infos\infos_persos_localisation.html.twig');
                break;
            
            case 'parametresConnexion':
                $template = sprintf('MindUserBundle:Compte:Infos\parametres_connexion.html.twig');
                break;
        }
        
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'user'  => $user
                ));
        
    }
    
}
