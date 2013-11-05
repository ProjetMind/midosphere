<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 *
 */

namespace Mind\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    
    public function getSuivisAvisAction($idUser){
     
        //Services
        $suivisService  = $this->container->get('mind_media.suivis');
        $imagesService  = $this->container->get('mind_media.images');
        $avisService    = $this->container->get('mind_site.avis');
        
        $avisSuivis = $suivisService->getSuivisAvis($idUser);
        
        //Images
        $imagesService->setTypeEntity('avis');
        $imagesAvis = $imagesService->getImages($avisSuivis);
        
        //
        $lesDates       = $avisService->getDatePublication($avisSuivis);
        $lesAuteurs     = $avisService->getAuteursAvis($avisSuivis);
        $lesNbCom       = $avisService->getNbCommentaireAvis($avisSuivis);
        
        $template = sprintf('MindSiteBundle::un_avis.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'lesAvis'       => $avisSuivis,
                        'titreGroup'    => 'Les avis que vous suivez',
                        'images'        => $imagesAvis,
                        'lesAuteurs'    => $lesAuteurs,
                        'lesDates'      => $lesDates,
                        'lesNbCom'      => $lesNbCom,
                        'pageType'      => 'supprimer_suivis', 
                        'routePaginator'    => ""
                     ));
    }
    
    public function getSuivisQuestionsAction($idUser){
        
        //Services
        $suivisService       = $this->container->get('mind_media.suivis');
        $imagesService       = $this->container->get('mind_media.images');
        $questionsService    = $this->container->get('mind_site.questions');
        
        $questionsSuivis = $suivisService->getSuivisQuestions($idUser);
        
        //
        $lesDates       = $questionsService->getDatePublication($questionsSuivis);
        $lesAuteurs     = $questionsService->getAuteursQuestion($questionsSuivis);
        $lesNbCom       = $questionsService->getNbCommentaireQuestion($questionsSuivis);
        
        $template = sprintf('MindSiteBundle::une_question.html.twig');
        
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'lesQuestions'  => $questionsSuivis,
                        'titreGroup'    => 'Les questions que vous suivez',
                        'lesAuteurs'    => $lesAuteurs,
                        'lesDates'      => $lesDates,
                        'lesNbCom'      => $lesNbCom,
                        'pageType'      => 'supprimer_suivis',
                        'routePaginator'    => ''
                     ));
        
    }

    public function indexAction($slug){
    
        $auteur = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('MindUserBundle:User')
                       ->findBy(array('slug'    => $slug));
        
        $template = sprintf('MindUserBundle:Profile:profile.html.twig');
        
        return $this->container->get('templating')->renderResponse($template,
                    array(
                            'slug'          => $slug,
                            'auteur'        => $auteur
                    )
                );
    }
    
    public function voirQuestionsAction($slug){
        
        $manager = $this->getDoctrine()->getManager();
        $questionRepository = $manager->getRepository('MindSiteBundle:Question');
        $template = sprintf('MindSiteBundle::une_question.html.twig');
        
        $auteur = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('MindUserBundle:User')
                       ->findBy(array('slug'    => $slug));
        
        $lesQuestions = $questionRepository->getQuestionsByAuteur($auteur[0]->getId());
        $titreGroup = "Les questions";
        
        $lesDomaines              =   $this->getDomaineWithLinkQuestion($lesQuestions, $manager);
        $lesAuteurs               =   $this->getAuteursQuestion($lesQuestions, $manager);
        $lesDatesDePublication    =   $this->getDatePublicationQuestion($lesQuestions, $manager);
        $lesNbCom                 =   $this->getNbCommentaireQuestion($lesQuestions, $manager);
      
        return $this->container->get('templating')->renderResponse($template, 
           array( 'lesQuestions'        => $lesQuestions, 
                  'lesDomaines'         => $lesDomaines,
                  'titreGroup'          => $titreGroup,
                  'lesAuteurs'          => $lesAuteurs,
                  'lesDates'            => $lesDatesDePublication,
                  'lesNbCom'            => $lesNbCom,
                  'auteur'              => $auteur
                   ));
        
    }
    
    
    /**
     * Show the user
     */
    public function voirAvisAction($slug)
    {
        $manager = $this->getDoctrine()->getManager();
        $avisRepository = $manager->getRepository('MindSiteBundle:Avis');
        $template = sprintf('MindSiteBundle::un_avis.html.twig');
        
        $auteur = $this->getDoctrine()
                       ->getManager()
                       ->getRepository('MindUserBundle:User')
                       ->findBy(array('slug'    => $slug));
        
        $lesAvis = $avisRepository->getAvisByAuteur($auteur[0]->getId());
        $titreGroup = "Les avis";
        
        $lesDomaines              =   $this->getDomaineWithLink($lesAvis, $manager);
        $lesAuteurs               =   $this->getAuteursAvis($lesAvis, $manager);
        $lesDatesDePublication    =   $this->getDatePublication($lesAvis, $manager);
        $lesNbCom                 =   $this->getNbCommentaireAvis($lesAvis, $manager);
        
        return $this->container->get('templating')->renderResponse($template, 
              array(
                    'lesAvis'           => $lesAvis,
                    'titreGroup'        => $titreGroup,
                    'lesDomaines'       => $lesDomaines,
                    'lesAuteurs'        => $lesAuteurs,
                    'lesDates'          => $lesDatesDePublication,
                    'lesNbCom'          => $lesNbCom,
                    'auteur'            => $auteur
                   ));
    }
    
    /**
   * 
   * Retourne les domaines dans un node avec des liens link
   * @param \Mind\SiteBundle\Entity\Avis $lesAvis
   * @return array 
   */
  public function getDomaineWithLink($lesAvis, $manager = null){
      
      $lesDomainesLink = array();
      $linkDomaine = array();
      $repositoryDomaine = $manager->getRepository('MindSiteBundle:Domaine');
      
      foreach ($lesAvis as $unAvis){
          
          $lesDomainesLink[$unAvis->getId()] = "";
          $idDuDomaineAvis = $unAvis->getAvisDomaine();
          $leDomaineAvis = $repositoryDomaine->find($idDuDomaineAvis);
          $leParent = $leDomaineAvis->getParent();
          $nbParent = count($leParent);
          
          $pathDomaine = $this->generateUrl('mind_site_domaine_voir', 
                                            array('slug'  => $leDomaineAvis->getSlug()));
          $linkDomaine[] = '<a href="'.$pathDomaine.'">'.$leDomaineAvis->getLibelle().'</a>';
          
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
                    $lesDomainesLink[$unAvis->getId()] .= $unLinkDomaine;
              }
              else{
                    $lesDomainesLink[$unAvis->getId()] .= $unLinkDomaine.' > ';
              }
              $countNbElements++;
          }
          
          $linkDomaine = array();
      }
      
      return $lesDomainesLink;
  }
  
  public function getLesVotes($lesAvis, $manager = null){
      
      $lesVotes = array();
      $repositoryOpinionAvis = $manager->getRepository('MindMediaBundle:OpinionAvis');
      
      foreach ($lesAvis as $unAvis){
          $idAvis = $unAvis->getId();
          $lesVotes[$idAvis] = array(
                                        'nbVotePositif' => $repositoryOpinionAvis->getOpinionAvisByIdAvis($idAvis, 1),
                                        'nbVoteMitige'  => $repositoryOpinionAvis->getOpinionAvisByIdAvis($idAvis, 2),
                                        'nbVoteNegatif' => $repositoryOpinionAvis->getOpinionAvisByIdAvis($idAvis, 3)    
                                    );
      }
      
      return $lesVotes;
  }
  
  public function getAuteursAvis($lesAvis, $manager = null){
      
      //On récupère l'id de l'auteur pour cahque avis
      //Pour chaque avis on récupère son le usergrace à l'id
      //On met l'auteur dans un tableau associatif
      
      $lesAuteurs = array();
      $infosAuteur = array();
      $repositoryUser = $manager->getRepository('MindUserBundle:User');
      
      foreach ($lesAvis as $unAvis){
          
        $idAuteur = $unAvis->getAvisAuteur();
        $auteurAvis = $repositoryUser->find($idAuteur);
        $slugAuteur = $auteurAvis->getSlug();
        $pathProfileAuteur = $this->generateUrl('mind_user_profile_voir', array('slug'  => $slugAuteur));
        $linkProfileAuteur = '<a href="'.$pathProfileAuteur.'"  title="'.$slugAuteur.'">%s</a>';
          
        $infosAuteur['pseudo'] = $auteurAvis->getUsername();
        $infosAuteur['id']  = $auteurAvis->getId();
        $infosAuteur['profileLink'] = sprintf($linkProfileAuteur, $infosAuteur['pseudo']);
        $infosAuteur['slug'] = $slugAuteur;
        
        $lesAuteurs[$unAvis->getId()] = $infosAuteur;
        
      }
      
      return $lesAuteurs;
  }

  public function getNbCommentaireAvis($lesAvis, $manager = null){
  
      $repositoryCommentaireAvis = $manager->getRepository('MindCommentaireBundle:CommentaireAvis');
      $lesNbCommentaires = array();
      
      foreach ($lesAvis as $unAvis){
          
          $idAvis = $unAvis->getId();
          $nbCommentaire = $repositoryCommentaireAvis->getNbCommentaireForAvis($idAvis);
          $lesNbCommentaires[$idAvis] = $nbCommentaire;
      }
      
      return $lesNbCommentaires;
  }
  
  
  /**
   * Retournes sous la date de publication 
   * @param type $lesAvis
   * @return Array
   */
  public function getDatePublication($lesAvis = null){
  
      $lesDates = array();
      $dateFormatage = new \Mind\SiteBundle\DateFormatage();
      
      foreach ($lesAvis as $unAvis){
          
          $datePublication = $unAvis->getAvisDatePublication();
          $laDateFormater = $dateFormatage->getDate($datePublication);
          $lesDates[$unAvis->getId()] = $laDateFormater;
          
      }
      
      return $lesDates;
  }
  
  public function ajouterAction()
  {

      //Création du formulaire à partir de l'entité et du type de formulaire
     $avis = new \Mind\SiteBundle\Entity\Avis;
     $form = $this->createForm(new AvisType(), $avis);
     
     //On récupère la classe requete
     $request = $this->getRequest();
     
    if($request->getMethod() == 'POST' )
    {
      // Ici, on s'occupera de la création et de la gestion du formulaire
        
        $form->bind($request);
        
        $idAuteur = $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
        $idDomaine = $form->getData()->getAvisDomaine()->getId();
        
        $avis->setAvisAuteur($idAuteur);
        $avis->setAvisDomaine($idDomaine);
        
        if($form->isValid()){
             
            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();
            
            //message de confirmation 
            $messageDeConfirmation = "L'avis a été publié avec succès.";
            $this->get('session')->getFlashBag()->add('success', $messageDeConfirmation);
            return $this->redirect($this->generateUrl('mind_site_homepage'));
        }
       
    }
    
    $lesDomaines = $this->getDomainesAction();
    
    $template = sprintf('MindSiteBundle:Forms:form_add_avis.html.twig'); 
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
                                        'avis'
                                    );     
       
       return $lesDomaines;
   }
   
   //QUESTION 
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
  
  public function getDomaineWithLinkQuestion($lesQuestions, $manager = null){
      
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
   
  public function getDatePublicationQuestion($lesQuestions, $manager = null){
  
      $lesDates = array();
      $dateFormatage = new \Mind\SiteBundle\DateFormatage();
      
      foreach ($lesQuestions as $uneQuestion){
          
          $datePublication = $uneQuestion->getQuestionDatePublication();
          $laDateFormater = $dateFormatage->getDate($datePublication);
          $lesDates[$uneQuestion->getId()] = $laDateFormater;
          
      }
      
      return $lesDates;
  }
}

