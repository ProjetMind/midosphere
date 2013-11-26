<?php

namespace Mind\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\MediaBundle\Controller\VoteQuestionController;
use Mind\SiteBundle\Form\Type\QuestionType;
use Symfony\Component\HttpFoundation\Response;
use Mind\SiteBundle\Form\Type\QuestionModifierType;
use JMS\SecurityExtraBundle\Annotation\Secure;

class QuestionController extends Controller
{
  public function indexAction($page)
  {
      $routeName    = $this->getRequest()->get('_route');
      $template     = sprintf('MindSiteBundle:Question:les_questions.html.twig');
      
      return $this->container->get('templating')->renderResponse($template, 
              array('routeName'     => $routeName,
                    'page'          => $page
                    ));
  }

  public function getQuestionsAction($page, $idAuteur = null){
      
      $routeName            = $this->getRequest()->get('_route');
      $manager              = $this->getDoctrine()->getManager();
      $repositoryQuestion   = $manager->getRepository('MindSiteBundle:Question');
      $template             = sprintf('MindSiteBundle::une_question.html.twig');
      $paginator            = $this->get('knp_paginator');
      $serviceQuestion      = $this->container->get('mind_site.questions');
      
      switch ($routeName){
          
          case 'mind_site_question_afficher':
              $lesQuestions = $repositoryQuestion->getQuestionsOrderDatePubDesc();
              $titreGroup = "Toutes les questions";
              break;
          
          case 'mind_site_question_afficher_recent':
                $lesQuestions = $repositoryQuestion->getQuestionsOrderDatePubDesc();
                $titreGroup = 'Les questions publiées récéments';
                break;
            
         case 'mind_site_question_afficher_anciens':
                $lesQuestions = $repositoryQuestion->getQuestionsOrderDatePubAsc();
                $titreGroup = "Les questions par ancienneté"; 
                break;
            
          case 'mind_site_question_afficher_plus_note':
                $lesQuestions = $repositoryQuestion->getQuestionsByNbVote();
                $titreGroup = 'Les questions les plus notées';
                break;
            
        case 'mind_site_question_afficher_plus_commente':
                $lesQuestions = $repositoryQuestion->getQuestionsByNbCommentaire();
                $titreGroup = 'Les questions les plus commentées'; 
                break;
            
        case 'get_questions_by_auteur':
                $lesQuestions = $repositoryQuestion->findBy(array('questionAuteur'=> $idAuteur));
                $titreGroup = 'Les questions de ce membre'; 
                break;
            
        case 'mind_site_domaine_voir':
                $lesQuestions = $repositoryQuestion->findBy(array('questionDomaine'=> $idAuteur));
                $titreGroup = 'Questions du domaine';
            break;
        
      }
      
      $lesQuestions = $paginator->paginate(
            $lesQuestions,
            $page/*page number*/,
            2/*limit per page*/
        );
      
      
    $lesDomaines              =   $serviceQuestion->getDomaineWithLink($lesQuestions);
    $lesAuteurs               =   $serviceQuestion->getAuteursQuestion($lesQuestions);
    $lesDatesDePublication    =   $serviceQuestion->getDatePublication($lesQuestions);
    $lesNbCom                 =   $serviceQuestion->getNbCommentaireQuestion($lesQuestions);
      
   return $this->container->get('templating')->renderResponse($template, 
           array( 'lesQuestions'        => $lesQuestions, 
                  'lesDomaines'         => $lesDomaines,
                  'titreGroup'          => $titreGroup,
                  'lesAuteurs'          => $lesAuteurs,
                  'lesDates'            => $lesDatesDePublication,
                  'lesNbCom'            => $lesNbCom,
                  'pageType'            => 'supprimer_entity',
                  'routePaginator'      => $routeName
                   ));
   
  }
  
  public function voirAction($auteur, $slug)
  {
      $serviceQuestion = $this->container->get('mind_site.questions');
      $manager = $this->getDoctrine()->getManager();
      $voteController = new VoteQuestionController();
      $question = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('MindSiteBundle:Question')
                       ->findQuestionsBySlug($slug);
      
      $lesDomaines              =   $serviceQuestion->getDomaineWithLink($question, $manager);
      $lesAuteurs               =   $serviceQuestion->getAuteursQuestion($question, $manager);
      $lesDatesDePublication    =   $serviceQuestion->getDatePublication($question, $manager);
      $lesNbCom                 =   $serviceQuestion->getNbCommentaireQuestion($question, $manager);
      $lesVotes                 =   $serviceQuestion->getLesVotes($question, $manager);
      
      $idQuestion = $question[0]->getId();
      $idAuteur = $lesAuteurs[$idQuestion]['id'];
      $aDejaVote = $voteController->aDejaVote($idQuestion, $idAuteur, $manager);
      
      $template = sprintf('MindSiteBundle:Question:une_question_lecture.html.twig');
      return $this->container->get('templating')->renderResponse($template, 
              array(  'lesQuestions'    => $question, 
                      'lesDomaines'     => $lesDomaines,
                      'lesAuteurs'      => $lesAuteurs,
                      'lesNbCom'        => $lesNbCom,
                      'lesDates'        => $lesDatesDePublication,
                      'aDejaVote'       => $aDejaVote,
                      'lesVotes'        => $lesVotes
                    ));
     
  }
 
   
  /**
   * @Secure(roles="ROLE_USER")
   * @return type
   */
  public function ajouterAction()
  {

      $suivis = $this->container->get('mind_media.suivis');
      $serviceAcl = $this->container->get('mind_site.acl_security');
      $domaineService = $this->container->get('mind_site.domaine');
      //Création du formulaire à partir de l'entité et du type de formulaire
     $question = new \Mind\SiteBundle\Entity\Question;
     $form = $this->createForm(new QuestionType(), $question);
     
     //On récupère la classe requete
     $request = $this->getRequest();
     
    if($request->getMethod() == 'POST' )
    {
      // Ici, on s'occupera de la création et de la gestion du formulaire
        
        $form->bind($request);
        
        $idAuteur = $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
        $question->setQuestionAuteur($idAuteur);
        
        if($form->isValid()){
            
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($question);
            $em->flush();
            
            //Suivis 
            $options = array(
                                'idUser'        => $idAuteur,
                                'idEntity'      => $question->getId(),
                                'typeEntity'    => 'question'
                            );
            
            $suivis->createSuivisForUser($options);
            
            //ACL
            $tabAcl     = array();
            $tabAcl[]   = $question;
            $serviceAcl->updateAcl($tabAcl);
            
            //message de confirmation 
            $messageDeConfirmation = "La question a été publié avec succès.";
            $this->get('session')->getFlashBag()->add('success', $messageDeConfirmation);
            return $this->redirect($this->generateUrl('mind_site_homepage'));
        }
       
    }
    
    $lesDomaines = $domaineService->getHtmlFormDomaineTree('question'); 
    
    $template = sprintf('MindSiteBundle:Forms:form_add_question.html.twig'); 
    return $this->container->get('templating')->renderResponse($template, array('lesDomaines'   => $lesDomaines,
                                                                                'form'  => $form->createView()
                                                                                ));
  }
  
  /**
   * @Secure(roles="ROLE_USER")
   * @param type $idQuestion
   * @return type
   */
  public function modifierAction($idQuestion)
  {
      $serviceQuestion = $this->container->get('mind_site.questions');
       $domaineService = $this->container->get('mind_site.domaine');
       
       $request = $this->getRequest();
       $em = $this->getDoctrine()->getManager();
       $domaineArray = $em->getRepository('MindSiteBundle:Domaine')->getAllDomainesInArray();
       $question = $serviceQuestion->getQuestionToUpdate($idQuestion);
       
       if($request->getMethod() == "POST"){
           
           $form = $this->createForm(new QuestionModifierType(), $question);
           
           $form->bind($request);
           $question->setQuestionDateEdition(new \DateTime());
           $question->setQuestionDomaine($domaineService->getDomaineWhoIsSelected('question'));
           
           if($form->isValid()){
               
               $em->persist($question);
               
               //Images
//                $actionImage = $this->container->get('mind_media.upload_file');
//                $images = $actionImage->createFileInfos();
//                $actionImage->persisteImagesForQuestion($images, $avis);
            
               $em->flush();
               
               //message de confirmation 
               $messageDeConfirmation = "La question a été modifié avec succès.";
               $this->get('session')->getFlashBag()->add('success', $messageDeConfirmation);
               return $this->redirect($this->generateUrl('mind_site_homepage'));
           }
       }else{
            
            $form = $this->createForm(new QuestionModifierType(), $question);
            
       }
       
       $lesDomaines = $domaineService->getHtmlFormDomaineTree('question', $question->getQuestionDomaine()); 
       
       $template = sprintf('MindSiteBundle:Forms:form_modifier_question.html.twig');
       return $this->container->get('templating')->renderResponse($template, 
               array(
                        'form'          => $form->createView(),
                        'idQuestion'        => $idQuestion,
                        'lesDomaines'   => $lesDomaines
               ));
  }
 
  /**
   * 
   * @Secure(roles="ROLE_USER")
   * @param type $idQuestion
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function supprimerAction($idQuestion)
  {   
      $request = $this->getRequest();
      $serviceQuestion = $this->container->get('mind_site.questions');
      $serviceSuivis = $this->container->get('mind_media.suivis');
      $serviceAbonnement = $this->container->get('mind_media.abonnement');
      $idUserCourant = $this->container->get('security.context')->getToken()->getUser()->getId();
      
      if($request->getMethod() == 'POST'){
          
          $idQuestion = $_POST['idQuestion'];
          
          if(!empty($idQuestion)){
              
              if(isset($_POST['supprimerQuestion'])){ 
                  $serviceQuestion->supprimerQuestion($idQuestion);
              }
              
              if(isset($_POST['supprimerSuivis'])){
                      
                      $options = array(
                                            'idUser'        => $idUserCourant,
                                            'idEntity'      => $idQuestion,
                                            'typeEntity'    => 'question'
                      );
                      $serviceSuivis->createSuivisForUser($options);
                      
              }
              
              
          }
      }
      
      $tab = json_encode(
              array(
                        'id'        => $idQuestion,
                        'formId'    => 'form'.$idQuestion
                    ));
      
      $response = new Response($tab);
      $response->headers->set('Content-Type', 'application/json');
      return $response;
  }
  
}