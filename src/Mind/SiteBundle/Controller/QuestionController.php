<?php

namespace Mind\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\MediaBundle\Controller\VoteQuestionController;
use Mind\SiteBundle\Form\Type\QuestionType;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
  public function indexAction($page)
  {
      $routeName = $this->getRequest()->get('_route');
      $template = sprintf('MindSiteBundle:Question:les_questions.html.twig');
      
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
      $paginator      = $this->get('knp_paginator');
      
      switch ($routeName){
          
          case 'mind_site_question_afficher':
              $lesQuestions = $repositoryQuestion->getQuestionsOrderDatePubAsc();
              $titreGroup = "Toutes les questions";
              break;
          
          case 'mind_site_question_afficher_recent':
                $lesQuestions = $repositoryQuestion->getQuestionsOrderDatePubAsc();
                $titreGroup = 'Les questions publiées récéments';
                break;
            
         case 'mind_site_question_afficher_anciens':
                $lesQuestions = $repositoryQuestion->getQuestionsOrderDatePubDesc();
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
      
      
    $lesDomaines              =   $this->getDomaineWithLink($lesQuestions, $manager);
    $lesAuteurs               =   $this->getAuteursQuestion($lesQuestions, $manager);
    $lesDatesDePublication    =   $this->getDatePublication($lesQuestions, $manager);
    $lesNbCom                 =   $this->getNbCommentaireQuestion($lesQuestions, $manager);
      
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
      $manager = $this->getDoctrine()->getManager();
      $voteController = new VoteQuestionController();
      $question = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('MindSiteBundle:Question')
                       ->findQuestionsBySlug($slug);
      
      $lesDomaines              =   $this->getDomaineWithLink($question, $manager);
      $lesAuteurs               =   $this->getAuteursQuestion($question, $manager);
      $lesDatesDePublication    =   $this->getDatePublication($question, $manager);
      $lesNbCom                 =   $this->getNbCommentaireQuestion($question, $manager);
      $lesVotes                 =   $this->getLesVotes($question, $manager);
      
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
  
  public function getNbCommentaireQuestion($lesQuestions, $manager = null){
  
      $repositoryCommentaireQuestion = $manager->getRepository('MindCommentaireBundle:CommentaireQuestion');
      $lesNbCommentaires = array();
      
      foreach ($lesQuestions as $uneQuestion){
          
          $idQuestion = $uneQuestion->getId();
          $nbCommentaire = $repositoryCommentaireQuestion->getNbCommentaireForQuestion($idQuestion);
          $lesNbCommentaires[$idQuestion] = $nbCommentaire;
      }
      
      return $lesNbCommentaires;
  }
  
  public function getDomaineWithLink($lesQuestions, $manager = null){
      
      $lesDomainesLink = array();
      $linkDomaine = array();
      $repositoryDomaine = $manager->getRepository('MindSiteBundle:Domaine');
     
      foreach ($lesQuestions as $uneQuestion){
          
          $lesDomainesLink[$uneQuestion->getId()] = "";
          $idDuDomaineQuestion = $uneQuestion->getQuestionDomaine();
          $leDomaineQuestion = $repositoryDomaine->find($idDuDomaineQuestion);
          $leParent = $leDomaineQuestion->getParent();
          $nbParent = count($leParent);
          
          $pathDomaine = $this->generateUrl('mind_site_domaine_voir', 
                                            array('slug'  => $leDomaineQuestion->getSlug()));
          $linkDomaine[] = '<a href="'.$pathDomaine.'">'.$leDomaineQuestion->getLibelle().'</a>';
         
          
          while($nbParent > 0){
              $pathParentDomaine = $this->generateUrl('mind_site_domaine_voir', 
                                                       array('slug' => $leParent->getSlug()));
              $linkDomaine[] = '<a href="'.$pathParentDomaine.'">' .$leParent->getLibelle().'</a>';
              $leParent = $leParent->getParent();
              $nbParent = count($leParent);
          }
          
          $linkDomaine = array_reverse($linkDomaine, true); 
          $nbElements = count($linkDomaine);
          $countNbElements = 1;
          
          foreach ($linkDomaine as $unLinkDomaine ){
              if($countNbElements == $nbElements){
                    $lesDomainesLink[$uneQuestion->getId()] .= $unLinkDomaine;
              }
              else{
                    $lesDomainesLink[$uneQuestion->getId()] .= $unLinkDomaine.' > ';
              }
              $countNbElements++;
          }
          
          $linkDomaine = array();
      }
      
      return $lesDomainesLink;
  }
  
  public function getAuteursQuestion($lesQuestions, $manager){
      
      //On récupère l'id de l'auteur pour cahque avis
      //Pour chaque avis on récupère son le usergrace à l'id
      //On met l'auteur dans un tableau associatif
      
      $lesAuteurs = array();
      $infosAuteur = array();
      $repositoryUser = $manager->getRepository('MindUserBundle:User');
      
      foreach ($lesQuestions as $uneQuestion){
          
        $idAuteur = $uneQuestion->getQuestionAuteur();
        $auteurQuestion = $repositoryUser->find($idAuteur);
        $slugAuteur = $auteurQuestion->getSlug();
        $pathProfileAuteur = $this->generateUrl('mind_user_profile_voir', array('slug'  => $slugAuteur));
        $linkProfileAuteur = '<a href="'.$pathProfileAuteur.'"  title="'.$slugAuteur.'">%s</a>';
          
        $infosAuteur['pseudo'] = $auteurQuestion->getUsername();
        $infosAuteur['id']  = $auteurQuestion->getId();
        $infosAuteur['profileLink'] = sprintf($linkProfileAuteur, $infosAuteur['pseudo']);
        $infosAuteur['slug'] = $slugAuteur;
        
        $lesAuteurs[$uneQuestion->getId()] = $infosAuteur;
        
      }
      
      return $lesAuteurs;
  }
   
  public function getDatePublication($lesQuestions, $manager = null){
  
      $lesDates = array();
      $dateFormatage = new \Mind\SiteBundle\DateFormatage();
      
      foreach ($lesQuestions as $uneQuestion){
          
          $datePublication = $uneQuestion->getQuestionDatePublication();
          $laDateFormater = $dateFormatage->getDate($datePublication);
          $lesDates[$uneQuestion->getId()] = $laDateFormater;
          
      }
      
      return $lesDates;
  }
   
  public function ajouterAction()
  {

      $suivis = $this->container->get('mind_media.suivis');
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
        $question->setQuestionDomaine($domaineService->getDomaineWhoIsSelected());
        
        
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
  
  public function getDomainesAction(){
       
      
       $lesDomaines = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('MindSiteBundle:Domaine')
                    ->childrenHierarchy(
                                        null, /* starting from root nodes */
                                        false, /* true: load all children, false: only direct */
                                        array(
                                            'decorate' => true),
                                        false, 
                                        'question'
                                            );     
       
       return $lesDomaines;
   }
   
 
  public function getLesVotes($lesQuestions, $manager = null){
      
      $lesVotes = array();
      $repositoryOpinionQuestion = $manager->getRepository('MindMediaBundle:OpinionQuestion');
      
      foreach ($lesQuestions as $uneQuestion){
          $idQuestion = $uneQuestion->getId();
          $lesVotes[$idQuestion] = array(
                                        'nbVotePositif' => $repositoryOpinionQuestion->getOpinionQuestionByIdQuestion($idQuestion, 1),
                                        'nbVoteMitige'  => $repositoryOpinionQuestion->getOpinionQuestionByIdQuestion($idQuestion, 2),
                                        'nbVoteNegatif' => $repositoryOpinionQuestion->getOpinionQuestionByIdQuestion($idQuestion, 3)    
                                    );
      }
      
      return $lesVotes;
  }
   
  public function modifierAction($id)
  {
    // Ici, on récupérera l'avis correspondant à $id
 
    // Ici, on s'occupera de la création et de la gestion du formulaire
 
    return $this->render('MindSiteBundle:Avis:modifier.html.twig');
  }
 
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