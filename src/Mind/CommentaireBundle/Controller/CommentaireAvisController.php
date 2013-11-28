<?php

namespace Mind\CommentaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\CommentaireBundle\Form\Type\CommentaireAvisType;
use JMS\SecurityExtraBundle\Annotation\Secure;

class CommentaireAvisController extends Controller
{
    /**
     * 
     * @Secure(roles="ROLE_USER")
     * 
     * @param type $idAvis
     * @return type
     * 
     */
    public function addCommentaireAvisAction($idAvis){
        
        $lesCommentaires = "";
        $data = array('template'            => "",
                      'lesCommentaires'     => "",
                      'lesDates'             => "",
                      'lesAuteurs'          => ""
                );
        
        $template = sprintf('MindCommentaireBundle:Forms:form_add_com_avis.html.twig');
        $commentaireAvis = new \Mind\CommentaireBundle\Entity\CommentaireAvis;
        $form = $this->createForm(new CommentaireAvisType, $commentaireAvis);
        
        $request = $this->getRequest();
        
        if($request->getMethod() == "POST"){
            
            $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
            $commentaireAvis->setCommentaireIdAuteur($idAuteur);
            $commentaireAvis->setIdAvis($idAvis);
            
            $form->bind($request);
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($commentaireAvis);
                $em->flush();
                
                //Acl 
                $serviceAcl = $this->container->get('mind_site.acl_security');
                $tabAcl     = array();
                $tabAcl[]   = $commentaireAvis;
                $serviceAcl->updateAcl($tabAcl);
                           
                $idCommentaire = $commentaireAvis->getId();
            }
            
            $data = $this->getLastCommentaireAvisAction($idAvis, $idCommentaire);
            $template = $data['template'];
            $lesCommentaires = $data['lesCommentaires'];
        }
        
        return $this->container->get('templating')->renderResponse($template, 
                array(  'form'      => $form->createView(),
                        'idAvis'    => $idAvis,
                        'lesCommentaires'   => $lesCommentaires,
                        'lesAuteursCom'     =>  $data['lesAuteurs'],
                        'lesDatesCom'       => $data['lesDates']
                      ));
    }
    
    public function getAuteurCommentaire($lesCommentaires){
        
        $lesAuteurs = array();
        
        $repositoryUser = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('MindUserBundle:User');
        
        
        foreach ($lesCommentaires as $unCommentaire){
            
            $idCommentaire = $unCommentaire->getId();
            $idAuteurUser = $unCommentaire->getCommentaireIdAuteur();
            $lesAuteurs[$idCommentaire] = $repositoryUser->find($idAuteurUser);
        }
        
        
        
        return $lesAuteurs;
    }


    public function getLastCommentaireAvisAction($idAvis, $idCommentaire){
        
        $commentairesAvis = $this->getDoctrine()
                                      ->getManager()
                                      ->getRepository('MindCommentaireBundle:CommentaireAvis')
                                      ->findBy(array(
                                          'idAvis'  => $idAvis, 
                                          'id'      => $idCommentaire
                                          ));
        
        $template = sprintf('MindCommentaireBundle::commentaires_lecture.html.twig');
        $lesAuteurs         = $this->getAuteurCommentaire($commentairesAvis);
        $lesDates           = $this->getDateFormatage($commentairesAvis);
        $data = array('template'            => $template,
                      'lesCommentaires'     => $commentairesAvis,
                      'lesDates'             => $lesDates,
                      'lesAuteurs'          => $lesAuteurs
                );
        
        return $data;
        
    }
    
    


    public function getCommentaireAvisAction($idAvis){
        
        
        $commentairesAvis = $this->getDoctrine()
                                      ->getManager()
                                      ->getRepository('MindCommentaireBundle:CommentaireAvis')
                                      ->getCommentairesByIdAvis($idAvis);
        
        
        
        $template           = sprintf('MindCommentaireBundle::commentaires_lecture.html.twig');
        $lesAuteurs         = $this->getAuteurCommentaire($commentairesAvis);
        $lesDates           = $this->getDateFormatage($commentairesAvis);
        
        return $this->container->get('templating')->renderResponse($template, 
                array('lesCommentaires'     => $commentairesAvis,
                      'lesAuteursCom'       => $lesAuteurs,
                      'lesDatesCom'         => $lesDates
                
                    ));
    }

    public function getDateFormatage($lesCommenataires){
        
        $lesDates = array();
        $dateFormatage = new \Mind\SiteBundle\DateFormatage();
        
        foreach ($lesCommenataires as $unCommentaire){
          
          $datePublication = $unCommentaire->getCommentaireDatePublication();
          $laDateFormater = $dateFormatage->getDate($datePublication);
          $lesDates[$unCommentaire->getId()] = $laDateFormater;
          
      }
      
      return $lesDates;
        
    }
    
}
