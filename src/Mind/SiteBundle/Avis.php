<?php

namespace Mind\SiteBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Mind\SiteBundle\DateFormatage;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContextInterface;

class Avis {
    
    protected $doctrine;
    protected $manager;
    protected $repository;
    protected $dateFormatage;
    protected $router;
    protected $security;

    public function __construct(Registry $doctrine, DateFormatage $dateFormatage, Router $router,
                                SecurityContextInterface $security) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->repository       = $this->manager->getRepository('MindMediaBundle:Suivis');
        $this->dateFormatage    = $dateFormatage;
        $this->router           = $router;
        $this->security         = $security;
    }
    
    public function getAvisToUpdate($idAvis){
        
        $avis = $this->manager
                     ->getRepository('MindSiteBundle:Avis')
                     ->find($idAvis);
        
        return $avis;
    }
    
    public function supprimerAvis($idAvis){
    
        $isAuteur = $this->isOurAvis($idAvis);
        $optionsSearch = array(
                                'id'            => $idAvis,
                                'avisAuteur'    => $this->security->getToken()->getUser()->getId()
                              );
        
        if($isAuteur == true){
            
            $avis = $this->manager
                         ->getRepository('MindSiteBundle:Avis')
                         ->findOneBy($optionsSearch);
                 
            $this->manager->remove($avis);
            $this->supprimerCommentaireAvis($idAvis);
            $this->supprimerImageAvis($idAvis);
            //supprimer suivis, abonnement
            $this->manager->flush();
        }
        
    }
    
    public function supprimerCommentaireAvis($idAvis){
        
        $commentaires = $this->manager
                            ->getRepository('MindCommentaireBundle:CommentaireAvis')
                            ->findBy(array('idAvis' => $idAvis));
        
        foreach ($commentaires as $unCommentaire){
            $this->manager->remove($unCommentaire);
        }
    }
    
    public function supprimerImageAvis($idAvis){
        
        $images = $this->manager
                      ->getRepository('MindMediaBundle:ImageAvis')
                      ->findBy(array('avis' => $idAvis));
        
        if(!empty($images)){
        foreach ($images as $uneImage){
           $this->manager->remove($uneImage);
        }}
        
    }
    
    public function isOurAvis($idAvis){
       
        $idUserCourant = $this->security->getToken()->getUser()->getId();
        $optionsSearch = array(
                                'id'            => $idAvis,
                                'avisAuteur'    => $idUserCourant
                              );
        
        $avis = $this->manager
                               ->getRepository('MindSiteBundle:Avis')
                               ->findOneBy($optionsSearch);
        
        if(empty($avis)){
            $isAuteur = false;
        }else{
            $isAuteur = true;
        }
        
        return $isAuteur;
    }
    
    public function getAuteursAvis($lesAvis){
      
      $lesAuteurs = array();
      $infosAuteur = array();
      $repositoryUser = $this->manager->getRepository('MindUserBundle:User');
      
      foreach ($lesAvis as $unAvis){
          
        $idAuteur = $unAvis->getAvisAuteur();
        $auteurAvis = $repositoryUser->find($idAuteur);
        $slugAuteur = $auteurAvis->getSlug();       
        $pathProfileAuteur = $this->router->generate('mind_user_profile_voir', array('slug'  => $slugAuteur));
        $linkProfileAuteur = '<a href="'.$pathProfileAuteur.'"  title="'.$slugAuteur.'">%s</a>';
          
        $infosAuteur['pseudo'] = $auteurAvis->getUsername();
        $infosAuteur['id']  = $auteurAvis->getId();
        $infosAuteur['profileLink'] = sprintf($linkProfileAuteur, $infosAuteur['pseudo']);
        $infosAuteur['slug'] = $slugAuteur;
        
        $lesAuteurs[$unAvis->getId()] = $infosAuteur;
        
      }
      
      return $lesAuteurs;
  }
  
  /**
   * Retournes sous la date de publication 
   * @param type $lesAvis
   * @return Array
   */
  public function getDatePublication($lesAvis){
  
      $lesDates = array();
     
      foreach ($lesAvis as $unAvis){
          
          $datePublication = $unAvis->getAvisDatePublication();
          $laDateFormater = $this->dateFormatage->getDate($datePublication);
          $lesDates[$unAvis->getId()] = $laDateFormater;
          
      }
      
      return $lesDates;
  }
  
  public function getNbCommentaireAvis($lesAvis){
  
      $repositoryCommentaireAvis = $this->manager->getRepository('MindCommentaireBundle:CommentaireAvis');
      $lesNbCommentaires = array();
      
      foreach ($lesAvis as $unAvis){
          
          $idAvis = $unAvis->getId();
          $nbCommentaire = $repositoryCommentaireAvis->getNbCommentaireForAvis($idAvis);
          $lesNbCommentaires[$idAvis] = $nbCommentaire;
      }
      
      return $lesNbCommentaires;
  }
}

?>
