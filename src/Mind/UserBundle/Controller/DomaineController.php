<?php

namespace Mind\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\SiteBundle\Form\Type\DomaineType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cette classe gère les domaine :
 * - Ajout de domaine
 * - Modification 
 * - Suppression 
 */
class DomaineController extends Controller
{
    
    /**
     * 
     * Permet l'ajout d'un nouveau domaine avec jquery form 
     * 
     * @return type
     */
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
    
    public function getDataSourceForParentAction(){
    
        $domaineService     = $this->container->get('mind_site.domaine');
        $domaines           = $this->getDoctrine()->getManager()->getRepository('MindSiteBundle:Domaine')->findAll();
        
        $arrayJson = array();
        
        foreach ($domaines as $domaine){
            
            $arrayJson[] = array(
                                    'value'     => $domaine->getId(),
                                    'text'      => $domaine->getLibelle()
                                );
        }
        
        $response = new Response(json_encode($arrayJson));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * 
     * permet de modifier une entité domaine
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifierAction(){
   
        $domaineService         = $this->container->get('mind_site.domaine'); 
        $typeChampToUpdate      = $this->getRequest()->get('name');
        $idDomaineToUpdate      = $this->getRequest()->get('pk');
        $newValue               = $this->getRequest()->get('value');
        $erreur                 = 'ok'; 
        $domaine                = $domaineService->getDomaineById($idDomaineToUpdate);
              
        
        switch ($typeChampToUpdate){
            
            case "libelle":
                $domaine->setLibelle($newValue);
                break;
            
            case "parent":
                $domaineService->updateDomaineParent($idDomaineToUpdate, $newValue);
                break;
            
            case "etat":
                break;
            
            default :
                $erreur = 'erreur';
                break;
        }
        
        if(!empty($domaine)){
            $domaineService->updateDomaine($domaine);
        }
        
        $tabJsonResponse = array(
                                    'message'       => $domaineService->getErreurMessage($erreur)
                                );
        
        $response = new Response(json_encode($tabJsonResponse));
        $response ->headers->set('Content-Type', 'application/json');
        
        return $response;
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
        //$htmlToDeleteDomaine = $domaineService->getBtnToEtat();
        
        $template = sprintf('MindUserBundle:Admin/Admin:domaines.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template, 
                                                array (
                                                        'listeDomaines'         => $listeDomaines,
                                                        //'htmlToDeleteDomaine'   => $htmlToDeleteDomaine
                                                                                     
                ));
    }
   
}
