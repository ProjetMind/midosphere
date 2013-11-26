<?php

namespace Mind\CommentaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Mind\CommentaireBundle\Form\Type\CommentaireQuestionType;

class CommentaireQuestionController extends Controller
{
    /**
     * 
     * @Secure(roles="ROLE_USER")
     * 
     * @param type $idQuestion
     * @return type
     * 
     */
    public function addCommentaireQuestionAction($idQuestion){
        
        $lesCommentaires = "";
        $data = array('template'            => "",
                      'lesCommentaires'     => "",
                      'lesDates'             => "",
                      'lesAuteurs'          => ""
                );
        
        $template = sprintf('MindCommentaireBundle:Forms:form_add_com_question.html.twig');
        $commentaireQuestion = new \Mind\CommentaireBundle\Entity\CommentaireQuestion;
        $form = $this->createForm(new CommentaireQuestionType, $commentaireQuestion);
        
        $request = $this->getRequest();
        
        if($request->getMethod() == "POST"){
            
            $form->bind($request);
            
            $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
            $commentaireQuestion->setCommentaireIdAuteur($idAuteur);
            $commentaireQuestion->setIdQuestion($idQuestion);
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($commentaireQuestion);
                $em->flush();
                           
                //Acl 
                $serviceAcl = $this->container->get('mind_site.acl_security');
                $tabAcl     = array();
                $tabAcl[]   = $commentaireQuestion;
                $serviceAcl->updateAcl($tabAcl);
                
                $idCommentaire = $commentaireQuestion->getId();
            }
            
            $data = $this->getLastCommentaireQuestionAction($idQuestion, $idCommentaire);
            $template = $data['template'];
            $lesCommentaires = $data['lesCommentaires'];
        }
        
        return $this->container->get('templating')->renderResponse($template, 
                array(  'form'      => $form->createView(),
                        'idQuestion'    => $idQuestion,
                        'lesCommentaires'   => $lesCommentaires,
                        'lesAuteursCom'     =>  $data['lesAuteurs'],
                        'lesDatesCom'       => $data['lesDates']
                      ));
    }
    
    public function getLastCommentaireQuestionAction($idQuestion, $idCommentaire){
        
        $commentairesQuestion = $this->getDoctrine()
                                      ->getManager()
                                      ->getRepository('MindCommentaireBundle:CommentaireQuestion')
                                      ->findBy(array(
                                          'idQuestion'  => $idQuestion, 
                                          'id'      => $idCommentaire
                                          ));
        
        $template = sprintf('MindCommentaireBundle::commentaires_lecture.html.twig');
        $lesAuteurs         = $this->getAuteurCommentaire($commentairesQuestion);
        $lesDates           = $this->getDateFormatage($commentairesQuestion);
        $data = array('template'            => $template,
                      'lesCommentaires'     => $commentairesQuestion,
                      'lesDates'             => $lesDates,
                      'lesAuteurs'          => $lesAuteurs
                );
        
        return $data;
        
    }
    
    public function getCommentaireQuestionAction($idQuestion){
        
        
        $commentairesQuestion = $this->getDoctrine()
                                      ->getManager()
                                      ->getRepository('MindCommentaireBundle:CommentaireQuestion')
                                      ->getCommentairesByIdQuestion($idQuestion);
        
        
        
        $template           = sprintf('MindCommentaireBundle::commentaires_lecture.html.twig');
        $lesAuteurs         = $this->getAuteurCommentaire($commentairesQuestion);
        $lesDates           = $this->getDateFormatage($commentairesQuestion);
        
        return $this->container->get('templating')->renderResponse($template, 
                array('lesCommentaires'     => $commentairesQuestion,
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
}
