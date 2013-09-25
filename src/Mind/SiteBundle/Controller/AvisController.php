<?php

namespace Mind\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\SiteBundle\Form\Type\AvisType;
use Mind\SiteBundle\Form\Type\AvisModifierType;
use Mind\MediaBundle\Controller\VoteAvisController;
use Symfony\Component\HttpFoundation\Response;

class AvisController extends Controller
{
   
    /**
     * 
     * Retourne simplement le template les_avis.html.twig
     * 
     * @return Template
     */
    public function indexAction(){
        
        $routeName = $this->getRequest()->get('_route');
        $template = sprintf('MindSiteBundle:Avis:les_avis.html.twig');

        return $this->container->get('templating')->renderResponse($template, 
              array('routeName'     => $routeName
                    ));
        
    }
    
    /**
     * 
     * Affiche tous les avis selon des critères 
     * 
     * @param type $page
     * @param type $idAuteur
     * @return type
     */
    public function getAvisAction($idAuteur = null){
        
        $routeName      = $this->getRequest()->get('_route');
        $manager        = $this->getDoctrine()->getManager();
        $repositoryAvis = $manager->getRepository('MindSiteBundle:Avis');
        $template       = sprintf('MindSiteBundle::un_avis.html.twig');
        
        switch ($routeName){
            
            case '':
                $lesAvis = $repositoryAvis->getAvisOrderDatePubDesc();
                $titreGroup = 'Les avis publiés récemment';
                break;
            
            case 'mind_site_avis_afficher': // par défaut les avis les plus récents sont affichés
                $lesAvis = $repositoryAvis->getAvisOrderDatePubDesc();
                $titreGroup = 'Tous les avis';
                break;
            
            case 'mind_site_avis_afficher_recent':
                $lesAvis = $repositoryAvis->getAvisOrderDatePubDesc();
                $titreGroup = 'Les avis publiés récemment';
                break;
            
            case 'mind_site_avis_afficher_anciens':
                $lesAvis = $repositoryAvis->getAvisOrderDateAsc();
                $titreGroup = "Les avis par ancienneté";
                break;
            
            case 'mind_site_avis_afficher_plus_note':
                $lesAvis = $repositoryAvis->getAvisByNbVote();
                $titreGroup = 'Les avis les plus notés';
                break;
            
            case 'mind_site_avis_afficher_plus_commente':
                $lesAvis = $repositoryAvis->getAvisByNbCommentaire();
                $titreGroup = 'Les avis les plus commentés'; 
                break;
            
            case 'get_avis_by_auteur':
                 $lesAvis = $repositoryAvis->getAvisByAuteur($idAuteur);
                 $titreGroup = "Les avis de ce membre";
                break;
            
            case 'mind_site_domaine_voir':
                $lesAvis = $repositoryAvis->getAvisByDomaine($idAuteur);
                $titreGroup = "Avis du domaine";
                break;
        }
        
        $lesDomaines              =   $this->getDomaineWithLink($lesAvis, $manager);
        $lesAuteurs               =   $this->getAuteursAvis($lesAvis, $manager);
        $lesDatesDePublication    =   $this->getDatePublication($lesAvis, $manager);
        $lesNbCom                 =   $this->getNbCommentaireAvis($lesAvis, $manager);
        $images                   =   $this->getImages($lesAvis);
        
        return $this->container->get('templating')->renderResponse($template, 
              array(
                    'lesAvis'           => $lesAvis,
                    'titreGroup'        => $titreGroup,
                    'lesDomaines'       => $lesDomaines,
                    'lesAuteurs'        => $lesAuteurs,
                    'lesDates'          => $lesDatesDePublication,
                    'lesNbCom'          => $lesNbCom,
                    'images'            => $images,
                    'pageType'              => 'supprimer_entity'
                   ));
    }
    
    public function getImages($lesAvis){
    
        $serviceImage = $this->container->get('mind_media.images');
        $serviceImage->setTypeEntity("avis");
        
        $images = $serviceImage->getImages($lesAvis);
        
        return $images;
    }
    
    /**
     * 
     * Retourne tous les avis sur d'une pages avec :
     *      - leur domaines
     *      - l'auteur
     *      - la date de publication
     * 
     * Cette fonction est appelé avec un render controller()
     * 
     * @param integer $page
     * @return renderResponse
     */
    public function getToutLesAvisAction($page){
      
      $routeName = $this->getRequest()->get('_route');
      $template = sprintf('MindSiteBundle:Avis:les_avis.html.twig');
      
      return $this->container->get('templating')->renderResponse($template, 
              array('routeName'     => $routeName
                    ));
    }
  
  /**
   * 
   * Retourne un avis que l'utilisateur veut lire avec : 
   *      - leur domaines
   *      - l'auteur
   *      - la date de publication
   * 
   * @param \Mind\UserBundle\Entity\User $auteur
   * @param \Mind\SiteBundle\Entity\Avis::slug $slug
   * 
   * @return renderResponse
   */
  public function voirAction($auteur, $slug)
  {
      $manager = $this->getDoctrine()->getManager();
      $voteController = new VoteAvisController;
      $serviceAvis = $this->container->get('mind_site.avis');
      
      $avis = $this->getDoctrine()
                               ->getManager()
                               ->getRepository('MindSiteBundle:Avis')
                               ->findAvisBySlug($slug);
    
      $lesDomaines              =   $this->getDomaineWithLink($avis, $manager);
      $lesAuteurs               =   $serviceAvis->getAuteursAvis($avis);
      $lesDatesDePublication    =   $this->getDatePublication($avis, $manager);
      $lesNbCom                 =   $this->getNbCommentaireAvis($avis, $manager);
      $lesVotes                 =   $this->getLesVotes($avis, $manager);
      $images                   =   $this->getImages($avis);
      
      $idAvis = $avis[0]->getId();
      $idAuteur = $lesAuteurs[$idAvis]['id'];
      $aDejaVote = $voteController->aDejaVote($idAvis, $idAuteur, $manager);
      
      $template = sprintf('MindSiteBundle:Avis:un_avis_lecture.html.twig');
      return $this->container->get('templating')->renderResponse($template, 
              array(
                        'lesAvis'           => $avis,
                        'lesDomaines'       => $lesDomaines,
                        'lesAuteurs'        => $lesAuteurs,
                        'lesDates'          => $lesDatesDePublication,
                        'lesNbCom'          => $lesNbCom,
                        'aDejaVote'         => $aDejaVote,
                        'lesVotes'          => $lesVotes,
                        'images'            => $images
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

     $suivis = $this->container->get('mind_media.suivis');
     $listener = $this->container->get('gedmo.listener.uploadable');
     $em = $this->getDoctrine()->getManager();
      
      //Création du formulaire à partir de l'entité et du type de formulaire
     $avis = new \Mind\SiteBundle\Entity\Avis;
     $form = $this->createForm(new AvisType(), $avis);
     
     //On récupère la classe requete
     $request = $this->getRequest();
     
    if($request->getMethod() == 'POST' )
    {
      // Ici, on s'occupera de la création et de la gestion du formulaire
        
        $form->bind($request);
        
        $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
        $idDomaine = $form->getData()->getAvisDomaine()->getId();
        
        $avis->setAvisAuteur($idAuteur);
        $avis->setAvisDomaine($idDomaine);
        
        if($form->isValid()){
             
            $em->persist($avis);
            $em->flush();
            
            //Suivis 
            $options = array(
                                'idUser'        => $idAuteur,
                                'idEntity'      => $avis->getId(),
                                'typeEntity'    => 'avis'
                            );
            
            $suivis->createSuivisForUser($options);
            
            //Images
            $actionImage = $this->container->get('mind_media.upload_file');
            $images = $actionImage->createFileInfos();
            $listener->setDefaultPath('../web/uploads/images/avis/'.$avis->getId());
            #echo $avis->getId();
            if(is_array($images)){

                foreach ($images as $uneImage){
                    
                    $imageAvis = new \Mind\MediaBundle\Entity\ImageAvis();
                    $imageAvis->setAvis($avis->getId());
                    $fileInfos = new \Gedmo\Uploadable\FileInfo\FileInfoArray($uneImage);
                    $listener->addEntityFileInfo($imageAvis, $fileInfos);

                    $em->persist($imageAvis);

                }
            }
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
   
   
   public function modifierAction($idAvis)
   {
       $serviceAvis = $this->container->get('mind_site.avis');
       $request = $this->getRequest();
       $em = $this->getDoctrine()->getManager();
       
       if($request->getMethod() == "POST"){
           
           $avis = new \Mind\SiteBundle\Entity\Avis;
           $form = $this->createForm(new AvisModifierType, $avis);
           
           if($form->isValid()){
               
               $em->persist($avis);
               $em->flush();
               
               //message de confirmation 
               $messageDeConfirmation = "L'avis a été modifié avec succès.";
               $this->get('session')->getFlashBag()->add('success', $messageDeConfirmation);
               return $this->redirect($this->generateUrl('mind_site_homepage'));
           }
       }else{
            $avis = $serviceAvis->getAvisToUpdate($idAvis);
            $form = $this->createForm(new AvisModifierType, $avis);
       }
       
       $template = sprintf('MindSiteBundle:Forms:form_modifier_avis.html.twig');
       return $this->container->get('templating')->renderResponse($template, 
               array(
                        'form'      => $form->createView(),
                        'idAvis'    => $idAvis
               ));
   }
 
  public function supprimerAction($idAvis)
  {   
      $request = $this->getRequest();
      $serviceAvis = $this->container->get('mind_site.avis');
      $serviceSuivis = $this->container->get('mind_media.suivis');
      $serviceAbonnement = $this->container->get('mind_media.abonnement');
      $idUserCourant = $this->container->get('security.context')->getToken()->getUser()->getId();
      
      if($request->getMethod() == 'POST'){
          
          $idAvis = $_POST['idAvis'];
          
          if(!empty($idAvis)){
              
              if(isset($_POST['supprimerAvis'])){ 
                  $serviceAvis->supprimerAvis($idAvis);
              }
              
              if(isset($_POST['supprimerSuivis'])){
                      
                      $options = array(
                                            'idUser'        => $idUserCourant,
                                            'idEntity'      => $idAvis,
                                            'typeEntity'    => 'avis'
                      );
                      $serviceSuivis->createSuivisForUser($options);
              }
              
              
          }
      }
      
      $tab = json_encode(
              array(
                        'id'        => $idAvis,
                        'formId'    => 'form'.$idAvis
                    ));
      
      $response = new Response($tab);
      $response->headers->set('Content-Type', 'application/json');
      return $response;
  }
}

?>