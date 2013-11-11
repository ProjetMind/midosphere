<?php

namespace Mind\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\SiteBundle\Form\Type\DomaineType;


/**
 * Cette classe gère les domaine :
 * - Ajout de domaine
 * - Modification 
 * - Suppression 
 */
class DomaineController extends Controller
{
    public function domainesAction(){
        
        $domaine = new \Mind\SiteBundle\Entity\Domaine;
        $form = $this->createForm(new DomaineType(), $domaine);
        $domaineService = $this->container->get('mind_site.domaine');
        
        $request = $this->getRequest('request');
        
        if($request->getMethod() == "POST")
        {
            $form->bind($request);
            
            $idAuteur = $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
            $domaine->setIdAuteur($idAuteur);
            
            
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($domaine);
                $em->flush();
                
                //On retournera peut-être la liste des videos
                $this->get('session')->getFlashBag()->add('success', 'Le domaine a été enregistré avec succées.');
                return $this->redirect( $this->generateUrl('mind_admin_domaine') );
            }
            
           
        }
        
        $lesDomaines    = $domaineService->getHtmlFormForAdmin();
        
        $template = sprintf('MindSiteBundle:Forms:form_add_domaine.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template, 
                                                                    array (
                                                                            'form' => $form->createView(),
                                                                            'lesDomaines'   => $lesDomaines
                                                                                     
                ));
        
    }
    
    /**
     * 
     * Fournit la liste des domaines pour la page d'administration
     * 
     * @return type
     */
    public function getListeDomaineAction(){
        
        $domaineService = $this->container->get('mind_site.domaine');
        
        $listeDomaines = $domaineService->getHtmlDomaineForAdmin();
        
        $template = sprintf('MindUserBundle:Admin/Admin:domaines.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template, 
                                                                    array (
                                                                            'listeDomaines' => $listeDomaines
                                                                                     
                ));
    }
   
}
