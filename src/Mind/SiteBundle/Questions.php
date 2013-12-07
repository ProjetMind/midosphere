<?php

namespace Mind\SiteBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Mind\SiteBundle\DateFormatage;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mind\SiteBundle\Acl\AclSecurity;

class Questions {
    
    protected $doctrine;
    protected $manager;
    protected $repository;
    protected $dateFormatage;
    protected $router;
    protected $security;
    protected $aclSecurity;


    public function __construct(Registry $doctrine, DateFormatage $dateFormatage, Router $router,
                                SecurityContextInterface $security, AclSecurity $aclSecurity) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->repository       = $this->manager->getRepository('MindMediaBundle:Suivis');
        $this->dateFormatage    = $dateFormatage;
        $this->router           = $router;
        $this->security         = $security;
        $this->aclSecurity      = $aclSecurity;
    }
    
    public function getQuestionToUpdate($idQuestion){
        
        $question = $this->manager
                            ->getRepository('MindSiteBundle:Question')
                            ->find($idQuestion);
        
        return $question;
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
            $this->aclSecurity->deleteAcl($question);
            
            $this->supprimerCommentaireQuestion($idQuestion);
            $this->supprimerSuivisQuestion($idQuestion);
            $this->manager->flush();
        }
        
    }
    
    public function supprimerSuivisQuestion($idQuestion){
        
        $suivis = $this->manager
                       ->getRepository('MindMediaBundle:Suivis')
                        ->findBy(
                                array(
                                        'idEntity'      => $idQuestion,
                                        'typeEntity'    => 'question'
                                    )
                                );
        
        foreach ($suivis as $unSuivis){
            $this->manager->remove($unSuivis);
            $this->aclSecurity->deleteAcl($unSuivis);
        }
    }
    
    public function supprimerCommentaireQuestion($idQuestion){
        
        $commentaires = $this->manager
                            ->getRepository('MindCommentaireBundle:CommentaireQuestion')
                            ->findBy(array('idQuestion' => $idQuestion));
        
        foreach ($commentaires as $unCommentaire){
            $this->manager->remove($unCommentaire);
            $this->aclSecurity->deleteAcl($unCommentaire);
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
    
    public function getDomaineWithLink($lesQuestions){
      
      $lesDomainesLink = array();
      $linkDomaine = array();
      $repositoryDomaine = $this->manager->getRepository('MindSiteBundle:Domaine');
     
      foreach ($lesQuestions as $uneQuestion){
          
          $lesDomainesLink[$uneQuestion->getId()] = "";
          $idDuDomaineQuestion = $uneQuestion->getQuestionDomaine();
          $leDomaineQuestion = $repositoryDomaine->find($idDuDomaineQuestion);
          $leParent = $leDomaineQuestion->getParent();
          $nbParent = count($leParent);
          
          $pathDomaine = $this->router->generate('mind_site_domaine_voir', 
                                            array('slug'  => $leDomaineQuestion->getSlug()));
          $linkDomaine[] = '<a href="'.$pathDomaine.'">'.$leDomaineQuestion->getLibelle().'</a>';
         
          
          while($nbParent > 0){
              $pathParentDomaine = $this->router->generate('mind_site_domaine_voir', 
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
  
  public function getLesVotes($lesQuestions){
      
      $lesVotes = array();
      $repositoryOpinionQuestion = $this->manager->getRepository('MindMediaBundle:OpinionQuestion');
      
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
}

?>
