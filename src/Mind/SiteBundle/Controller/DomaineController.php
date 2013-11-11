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
use Symfony\Component\Routing\Router;

/**
 * 
 */
class DomaineController extends Controller
{
    public function getDomainesTreeAction(){
    
        $domaines = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('MindSiteBundle:Domaine')
                        ->getDomainesTree();
        
        $template = sprintf('MindSiteBundle:Forms:form_domaines_tree.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'domaines'  => $domaines
                ));
    }
    
    /**
     * Gestion de l'ajout de domaine
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
                
                if($this->container->get('request')->get('mind_sitebundle_domainetype[etat]') == 1){
                    $messageDomaine = "Le domaine a été publié.";
                    $this->get('session')->getFlashBag()->add('success', $messageDomaine);
                }
                else{
                    $messageDomaine = "Le domaine n'a pas été publié. Pensez à le publié.";
                    $this->get('session')->getFlashBag()->add('erreurs',$messageDomaine);
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
        $lesDomaines    = $domaineService->getHtmlListeDomaine();
        
        $template = sprintf('MindSiteBundle:Domaines:page_domaines.html.twig');
        return $this->container->get('templating')->renderResponse($template,
                    array(
                            'lesDomaines'       => $lesDomaines
                    ));
        
    }
    

    public function voirAction($slug){
        
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

    public function getDomaineWithAvisAction($slug){
        
        $controllerAvis = new AvisController();
        $manager    = $this->getDoctrine()->getManager();
        
        $leDomaine = $this->getDoctrine()
                          ->getManager()
                          ->getRepository('MindSiteBundle:Domaine')
                          ->getDomaineBySlug($slug);
        
        $idDuDomaine = $leDomaine->getId();
        
        $lesAvis = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('MindSiteBundle:Avis')
                        ->getAvisByDomaine($idDuDomaine);
                      
        $lesDomaines                = $controllerAvis->getDomaineWithLink($lesAvis, $manager);
        $lesAuteurs                 = $controllerAvis->getAuteursAvis($lesAvis, $manager); 
        $lesDatesDePublication      = $controllerAvis->getDatePublication($lesAvis, $manager);  

        $template = sprintf('MindSiteBundle:Avis:tout_les_avis.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array('titreGroupAvis'  => "Les avis du domaine",
                      'lesAvis' => $lesAvis, 
                      'lesDomaines' => $lesDomaines,
                      'lesAuteurs'  => $lesAuteurs,
                      'lesDates'    => $lesDatesDePublication
                       ));
        
    }
    
    public function getDomainesAjaxAction($id){
       
       
       $domaine = new \Mind\SiteBundle\Entity\Avis;
       $form = $this->createForm(new \Mind\SiteBundle\Form\Type\GetDomainesType($id), $domaine);
       
       $template = sprintf('MindSiteBundle:Forms:form_get_domaines.html.twig');
       return  $this->container->get('templating')->renderResponse($template, array('form'  => $form->createView()
                
       ));
         
   }
   
   public function getMetaDataDomaine(){
       
       return $this->getDoctrine()
                   ->getManager()
                   ->getRepository('MindSiteBundle:Domaine')
                   ->getMetaDataDomaine();
   }
   
   
}
