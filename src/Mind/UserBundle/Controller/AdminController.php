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



/**
 * 
 */
class AdminController extends Controller
{
   
    public function adminAction()
    {
        $template = sprintf('MindUserBundle:Admin:admin.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template);
    }
    
    public function usersAction(){
        
        $template = sprintf('MindUserBundle:Admin/Admin:users.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template);
        
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
                $em = $this->getDoctrine()->getEntityManager();
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
    
    public function getListeDomaineUn(){ 
       
        $repository = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('MindSiteBundle:Domaine');
        
        $tabDomaineUn = $repository->getDomaineNiveauUn();
        
        
        return $tabDomaineUn;
        
    }
    
    public function getSousDomaine($tabDomaineUn){
        
        $clee = "";
        $valeur = "";
        
        if(!empty($tabDomaineUn)){
            
            foreach ($lesIdSousDomaine as $clee => $valeur){
                
            }
        }
        
        
    }
    
}
