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
               
//                if($this->container->get('request')->get('mind_sitebundle_domainetype[etat]') == 1){
//                    $messageDomaine = "Le domaine a été publié.";
//                    $this->get('session')->getFlashBag()->add('success', $messageDomaine);
//                }
//                else{
//                    $messageDomaine = "Le domaine n'a pas été publié. Pensez à le publié.";
//                    $this->get('session')->getFlashBag()->add('warning',$messageDomaine);
//                }
                
                //On retournera peut-être la liste des videos
                $this->get('session')->getFlashBag()->add('success', 'Le domaine a été enregistré avec succées.');
                return $this->redirect( $this->generateUrl('mind_admin_domaine') );
            }
            
           
        }
        
        $listeDomaines = $this->getDomainesPourAdministration();
        
        $template = sprintf('MindUserBundle:Admin/Admin:domaines.html.%s', $this->container->getParameter('fos_user.template.engine'));
        return $this->container->get('templating')->renderResponse($template, array ('form' => $form->createView(),
                                                                                     'listeDomaines' => $listeDomaines
                ));
        
    }
    
   public function getDomainesPourAdministration(){
       
       $listeDomaines = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('MindSiteBundle:Domaine')
                   ->getDomainesPourAdministration();
       
         return  $this->getDomainesAvecHtml($listeDomaines, 0);
   }
   
   public function getDomainesAvecHtml($listeDomaines, $niveauAccordeonId){
       
       $htmlAccordeon = "";
       $accordeonId = $niveauAccordeonId;
       
       foreach($listeDomaines as $value){
          
           $domaineHtmlOpen = $this->getAccordeonHtmlOpen($value, $accordeonId);
           
           
           if(!empty($value['__children'])){
               $niveauAccordeonId = $accordeonId + 1;
               $sousDomaine = $this->getAccordeonHtmlStart($niveauAccordeonId).
                              $this->getDomainesAvecHtml($value['__children'], $niveauAccordeonId).
                              $this->getAccordeonHtmlEnd();
           }
           else
           {
               $sousDomaine = "Il ne y'a pas de sous domaine pour cet élément.";
           }
           $domaineHtmlClose = $this->getAccordeonHtmlClose();
           
           $htmlAccordeon .= $domaineHtmlOpen.$sousDomaine.$domaineHtmlClose;
       }
       
       return $htmlAccordeon;
       
   }
   
   public function getAccordeonHtmlStart($niveauAccordeonId){
       
       $domaineAccordeonHtmlStart = '<div class="accordion" id="accordion'.$niveauAccordeonId.'">';
       
       return $domaineAccordeonHtmlStart;
   }
   
   public function getAccordeonHtmlEnd(){
       
       $domaineAccordeonHtmlEnd = '</div>';
       
       return $domaineAccordeonHtmlEnd;
   }

   public function getAccordeonHtmlOpen($unDomaine, $accordeonId){
       
       $domaineHtmlOpen = '<div class="accordion-group">
            
            <div class="accordion-heading">
                <a href="#" style="display: inline-block">
                    '.$unDomaine['libelle'].'
                    <span class="accordion-toggles icon-plus" data-toggle="collapse" data-parent="#accordion'.$accordeonId.'" href="#'.$unDomaine['id'].'">
                        
                    </span>
                </a>
            </div>
                
            <div id="'.$unDomaine['id'].'" class="accordion-body collapse">
                <div class="accordion-inner">';
       
       return $domaineHtmlOpen;
   }
   
   public function getAccordeonHtmlClose(){
       
       $domaineHtmlClose = '</div>
            </div>
        </div>';
       
       return $domaineHtmlClose;
   }
}
