<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mind\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\SiteBundle\Form\Type\DomaineType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * 
 */
class DomaineController extends Controller
{

    
    /**
     * 
     * Gestion de l'ajout de domaine
     * 
     * @Secure(roles="ROLE_ADMIN")
     * 
     * @return type
     */
    public function domainesAction(){
        
        $domaine = new \Mind\SiteBundle\Entity\Domaine;
        $form = $this->createForm(new DomaineType(), $domaine);
        $domaineService = $this->container->get('mind_site.domaine');
        $serviceBootstrapFlash = $this->container->get('bc_bootstrap.flash');
        
        $request = $this->getRequest('request');
        
        if($request->getMethod() == "POST")
        {
            $idAuteur = $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
            $domaine->setIdAuteur($idAuteur);
            
            $form->bind($request);
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($domaine);
                $em->flush();
                
                //Acl
                $serviceAcl = $this->container->get('mind_site.acl_security');
                $tabAcl     = array();
                $tabAcl[]   = $domaine;
                $serviceAcl->updateAcl($tabAcl);
                
                $etat = $domaine->getEtat();
                if($etat == 1){
                    $messageDomaine = "Le domaine a été publié.";
                    $serviceBootstrapFlash->success($messageDomaine);
                }
                else{
                    $messageDomaine = "Le domaine n'a pas été publié. Pensez à le publié.";
                    $serviceBootstrapFlash->info($messageDomaine);
                }
                
                //On retournera peut-être la liste des videos
                return $this->redirect( $this->generateUrl('mind_admin_domaine') );
            }
            
           
        }
        
        $lesDomaines = $domaineService->getHtmlDomaineForAdmin();
        
        $template = sprintf('MindUserBundle:Admin/Admin:domaines.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template, array ('form' => $form->createView(),
                                                                                     'lesDomaines' => $lesDomaines
                ));
        
    }
    
    /**
     * 
     * Liste des domaines pour la page domaine
     * 
     * @return type
     */
    public function getListeDomainePageAction(){
        
        $domaineService = $this->container->get('mind_site.domaine');
        $lesDomaines    = $domaineService->getListeDomaine();
        
        $template = sprintf('MindSiteBundle:Domaines:page_domaines.html.twig');
        return $this->container->get('templating')->renderResponse($template,
                    array(
                            'lesDomaines'       => $lesDomaines[0],
                            'lettres'         => $lesDomaines[1]
                    ));
        
    }
    
    
    public function voirAction($slug){
        
        $servicePaginator = $this->container->get('knp_paginator');
        $limitParPage   = 200000000000;
        
        $leDomaine = $this->getDoctrine()
                          ->getManager()
                          ->getRepository('MindSiteBundle:Domaine')
                          ->findOneBy(array('slug'=>$slug));
               
        $template = sprintf('MindSiteBundle:Domaines:un_domaine_lecture.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'leDomaine'     => $leDomaine
                ));
        
        
    }


    public function getDomainesAjaxAction($id){
       
       
       $domaine = new \Mind\SiteBundle\Entity\Avis;
       $form = $this->createForm(new \Mind\SiteBundle\Form\Type\GetDomainesType($id), $domaine);
       
       $template = sprintf('MindSiteBundle:Forms:form_get_domaines.html.twig');
       return  $this->container->get('templating')->renderResponse($template, array('form'  => $form->createView()
                
       ));
         
   }

   public function getDomaineForFormAction(){
       
       $serviceDomaine = $this->container->get('mind_site.domaine');
       $arrayDomaine = $serviceDomaine->getDomaineForForm();
       
       $response = new \Symfony\Component\HttpFoundation\Response(json_encode($arrayDomaine));
       $response->headers->set('Content-Type', 'application/json');
       
       return $response;
   }
   
}
