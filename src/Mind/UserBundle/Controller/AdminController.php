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
use Mind\SiteBundle\Form\Type\DomaineType;
use Mind\UserBundle\Form\Type\UpdateRolesType;



/**
 * 
 * Class unitilisé je crois 
 */
class AdminController extends Controller
{
   
    public function adminAction()
    {
        $template = sprintf('MindUserBundle:Admin:admin.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template);
    }
    
    public function usersAction(){
        
        $users = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('MindUserBundle:User')
                      ->findAll();
        
        $template = sprintf('MindUserBundle:Admin/Admin:users.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'users'     => $users
                ));
        
    }
    
    public function domainesAction(){
        
        $domaine = new \Mind\SiteBundle\Entity\Domaine;
        $form = $this->createForm(new DomaineType(), $domaine);
        
        $request = $this->getRequest('request');
        
        if($request->getMethod() == "POST")
        {
            $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
            $domaine->setIdAuteur($idAuteur);
            $domaine->setDateCreation(new \DateTime);
            $domaine->setDomaineSup(-1);
            
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($domaine);
                $em->flush();
                
                if($this->container->get('request')->get('mind_sitebundle_domainetype[etat]') == 1){
                    $messageDomaine = "Le domaine a été publié.";
                    $this->get('session')->getFlashBag()->add('domaine-publie-ou-pas', $messageDomaine);
                }
                else{
                    $messageDomaine = "Le domaine n'a pas été publié. Pensez à le publié.";
                    $this->get('session')->getFlashBag()->add('domaine-publie-ou-pas',$messageDomaine);
                }
                
                //On retournera peut-être la liste des videos
                $this->get('session')->getFlashBag()->add('domaine-enregistre', 'Le domaine a été enregistré avec succées.');
                return $this->redirect( $this->generateUrl('mind_admin_domaine') );
            }
            
           
        }
        
        $listeRacine = $this->getListeDomaineUn();
        
        $template = sprintf('MindUserBundle:Admin/Admin:domaines.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template, array(
                                                                                     'form' => $form->createView(),
                                                                                     'listeRacine' => $listeRacine
                ));
        
    }
    
    
    public function avisAction(){
        
        
        $template = sprintf('MindUserBundle:Admin/Admin:avis.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template);
        
    }
    
    public function questionsAction(){
        
        $template = sprintf('MindUserBundle:Admin/Admin:questions.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template);
    }
   
    
    public function UpdateUserRolesAction($idUser){
        
        $user = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('MindUserBundle:User')
                     ->find($idUser);
        
        $form = $this->createForm(new UpdateRolesType(), $user);
        
        $request = $this->getRequest();
        if($request->getMethod() === "POST"){
        
            $form->bindRequest($request);
            
            if($form->isValid()){
                $em = $this->getDoctrine()
                           ->getManager();
                $em->persist($user);
                $em->flush();
                
                $url = $this->generateUrl('mind_admin_user');
                return $this->redirect($url);
            }
        }
        
        
        $template = 'MindUserBundle:Form:form_update_roles.html.twig';
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'form'  => $form->createView(),
                        'idUser'=> $idUser
                ));
    }
    
}
