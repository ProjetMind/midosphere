<?php

namespace Mind\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\SiteBundle\Form\Type\DomaineType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
     * @Secure(roles="ROLE_ADMIN")
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
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($domaine);
                $em->flush();
                
                $message = 'Le domaine a été enregistré avec succées.';
                $serviceBootstrapFlash->success($message);
                
                return new Response();
                //return $this->redirect( $this->generateUrl('mind_admin_domaine') );
            }
            
           return new Response();
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
     * @param type $id
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function supprimerAction($id){
        
        $serviceBootstrapFlash = $this->container->get('bc_bootstrap.flash');
        $domaineService = $this->container->get('mind_site.domaine');
        $domaine = $domaineService->getDomaineById($id);
        $ok = $domaineService->supprimer($domaine);
        
        if($ok === true){
            $serviceBootstrapFlash->success('Le domaine " '.$domaine->getLibelle().'" à été supprimé.');
        }else{
            $serviceBootstrapFlash->error('Une erreur inconnue est survenue lors de la tentative de suppression.');
        }
        
        return $this->redirect($this->generateUrl('mind_admin_domaine'));
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
