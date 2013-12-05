<?php

namespace Mind\SiteBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Mind\SiteBundle\DateFormatage;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mind\MediaBundle\Images;

class Avis {
    
    protected $doctrine;
    protected $manager;
    protected $repository;
    protected $dateFormatage;
    protected $router;
    protected $security;
    protected $images;

    public function __construct(Registry $doctrine, DateFormatage $dateFormatage, Router $router,
                                SecurityContextInterface $security, Images $images) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->repository       = $this->manager->getRepository('MindMediaBundle:Suivis');
        $this->dateFormatage    = $dateFormatage;
        $this->router           = $router;
        $this->security         = $security;
        $this->images           = $images;
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
            $this->supprimerSuivisAvis($idAvis);
            $this->manager->flush();
        }
        
    }
    
    public function supprimerSuivisAvis($idAvis){
        
        $suivis = $this->manager
                       ->getRepository('MindMediaBundle:Suivis')
                        ->findBy(
                                array(
                                        'idEntity'      => $idAvis, 
                                        'typeEntity'    => 'avis'
                                    )
                                );
        
        foreach ($suivis as $unSuivis){
            $this->manager->remove($unSuivis);
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
  
  /**
   * 
   * Retourne les domaines dans un node avec des liens link
   * @param \Mind\SiteBundle\Entity\Avis $lesAvis
   * @return array 
   */
  public function getDomaineWithLink($lesAvis){
      
      $lesDomainesLink = array();
      $linkDomaine = array();
      $repositoryDomaine = $this->manager->getRepository('MindSiteBundle:Domaine');
      
      foreach ($lesAvis as $unAvis){
          
          $lesDomainesLink[$unAvis->getId()] = "";
          $idDuDomaineAvis = $unAvis->getAvisDomaine();
          $leDomaineAvis = $repositoryDomaine->find($idDuDomaineAvis);
          $leParent = $leDomaineAvis->getParent();
          $nbParent = count($leParent);
          
          $pathDomaine = $this->router->generate('mind_site_domaine_voir', 
                                            array('slug'  => $leDomaineAvis->getSlug()));
          $linkDomaine[] = '<a href="'.$pathDomaine.'">'.$leDomaineAvis->getLibelle().'</a>';
          
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
  
  public function getImages($lesAvis){
    
        $this->images->setTypeEntity("avis");
        
        $images = $this->images->getImages($lesAvis);
        
        return $images;
    }
    
    public function getLesVotes($lesAvis){
      
      $lesVotes = array();
      $repositoryOpinionAvis = $this->manager->getRepository('MindMediaBundle:OpinionAvis');
      
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
}

?>
