<?php

namespace Mind\SiteBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Mind\SiteBundle\DateFormatage;
use Symfony\Component\Routing\Router;

class Questions {
    
    protected $doctrine;
    protected $manager;
    protected $repository;
    protected $dateFormatage;
    protected $router;
    
    public function __construct(Registry $doctrine, DateFormatage $dateFormatage, Router $router) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->repository       = $this->manager->getRepository('MindMediaBundle:Suivis');
        $this->dateFormatage    = $dateFormatage;
        $this->router           = $router;
    }
    
    public function getDatePublication($lesQuestions){
  
      $lesDates = array();
      
      foreach ($lesQuestions as $uneQuestion){
          
          $datePublication = $uneQuestion->getQuestionDatePublication();
          $laDateFormater = $this->dateFormatage->getDate($datePublication);
          $lesDates[$uneQuestion->getId()] = $laDateFormater;
          
      }
      
      return $lesDates;
  }
  
  public function getAuteursQuestion($lesQuestions){
      
      //On récupère l'id de l'auteur pour cahque avis
      //Pour chaque avis on récupère son le usergrace à l'id
      //On met l'auteur dans un tableau associatif
      
      $lesAuteurs = array();
      $infosAuteur = array();
      $repositoryUser = $this->manager->getRepository('MindUserBundle:User');
      
      foreach ($lesQuestions as $uneQuestion){
          
        $idAuteur = $uneQuestion->getQuestionAuteur();
        $auteurQuestion = $repositoryUser->find($idAuteur);
        $slugAuteur = $auteurQuestion->getSlug();
        $pathProfileAuteur = $this->router->generate('mind_user_profile_voir', array('slug'  => $slugAuteur));
        $linkProfileAuteur = '<a href="'.$pathProfileAuteur.'"  title="'.$slugAuteur.'">%s</a>';
          
        $infosAuteur['pseudo'] = $auteurQuestion->getUsername();
        $infosAuteur['id']  = $auteurQuestion->getId();
        $infosAuteur['profileLink'] = sprintf($linkProfileAuteur, $infosAuteur['pseudo']);
        $infosAuteur['slug'] = $slugAuteur;
        
        $lesAuteurs[$uneQuestion->getId()] = $infosAuteur;
        
      }
      
      return $lesAuteurs;
  }
  
  public function getNbCommentaireQuestion($lesQuestions){
  
      $repositoryCommentaireQuestion = $this->manager->getRepository('MindCommentaireBundle:CommentaireQuestion');
      $lesNbCommentaires = array();
      
      foreach ($lesQuestions as $uneQuestion){
          
          $idQuestion = $uneQuestion->getId();
          $nbCommentaire = $repositoryCommentaireQuestion->getNbCommentaireForQuestion($idQuestion);
          $lesNbCommentaires[$idQuestion] = $nbCommentaire;
      }
      
      return $lesNbCommentaires;
  }
  
  public function supprimerQuestion($idQuestion){
    
        $isAuteur = $this->isOurQuestion($idQuestion);
        $optionsSearch = array(
                                'id'            => $idQuestion,
                                'questionAuteur'    => $this->security->getToken()->getUser()->getId()
                              );
        
        if($isAuteur == true){
            
            $question = $this->manager
                         ->getRepository('MindSiteBundle:Question')
                         ->findOneBy($optionsSearch);
                 
            $this->manager->remove($question);
            $this->supprimerCommentaireAvis($idQuestion);
            //supprimer suivis, abonnement
            $this->manager->flush();
        }
        
    }
    
    public function isOurQuestion($idQuestion){
       
        $idUserCourant = $this->security->getToken()->getUser()->getId();
        $optionsSearch = array(
                                'id'            => $idQuestion,
                                'questionAuteur'    => $idUserCourant
                              );
        
        $question = $this->manager
                               ->getRepository('MindSiteBundle:Question')
                               ->findOneBy($optionsSearch);
        
        if(empty($question)){
            $isAuteur = false;
        }else{
            $isAuteur = true;
        }
        
        return $isAuteur;
    }
}

?>
