<?php

namespace Mind\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\SiteBundle\Form\Type\AvisType;
use Mind\SiteBundle\Form\Type\AvisModifierType;
use Mind\MediaBundle\Controller\VoteAvisController;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

class AvisController extends Controller
{
   
    /**
     * 
     * Retourne simplement le template les_avis.html.twig
     * 
     * @return Template
     */
    public function indexAction($page){
        
        $routeName = $this->getRequest()->get('_route');
        $template = sprintf('MindSiteBundle:Avis:les_avis.html.twig');

        return $this->container->get('templating')->renderResponse($template, 
              array('routeName'     => $routeName, 
                    'page'          => $page
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
    public function getAvisAction($page, $idAuteur = null){
        
        $routeName      = $this->getRequest()->get('_route');
        $manager        = $this->getDoctrine()->getManager();
        $repositoryAvis = $manager->getRepository('MindSiteBundle:Avis');
        $template       = sprintf('MindSiteBundle::un_avis.html.twig');
        $paginator      = $this->get('knp_paginator');
        $limitParPage   = 6;
        $serviceAvis    = $this->container->get('mind_site.avis');
                
        switch ($routeName){
            
            case '':
                $lesAvis = $repositoryAvis->getAvisOrderDatePubDesc();
                $titreGroup = 'Les avis publiés récemment';
                break;
            
            case 'mind_site_avis_afficher': // par défaut les avis les plus récents sont affichés
                $lesAvis = $repositoryAvis->getAvisOrderDatePubDesc();
                $titreGroup = 'Tous les avis';
                break;
            
            case 'avis_for_accueil':
                $lesAvis = $repositoryAvis->getAvisOrderDatePubDesc();
                $titreGroup = 'Les avis publiés récemment';
                break;
            
            case 'mind_site_avis_afficher_recent':
                $lesAvis = $repositoryAvis->getAvisOrderDatePubDesc();
                $titreGroup = 'Les avis publiés récemment';
                break;
            
            case 'mind_site_avis_afficher_anciens':
                $lesAvis = $repositoryAvis->getAvisOrderDatePubAsc();
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
                $limitParPage = 2000000000000;
                break;
        }
        
        $lesAvis = $paginator->paginate(
            $lesAvis,
            $page/*page number*/,
            $limitParPage/*limit per page*/
        );
        
        $lesDomaines              =   $serviceAvis->getDomaineWithLink($lesAvis);
        $lesAuteurs               =   $serviceAvis->getAuteursAvis($lesAvis);
        $lesDatesDePublication    =   $serviceAvis->getDatePublication($lesAvis);
        $lesNbCom                 =   $serviceAvis->getNbCommentaireAvis($lesAvis);
        $images                   =   $serviceAvis->getImages($lesAvis);
        
        return $this->container->get('templating')->renderResponse($template, 
              array(
                    'lesAvis'           => $lesAvis,
                    'titreGroup'        => $titreGroup,
                    'lesDomaines'       => $lesDomaines,
                    'lesAuteurs'        => $lesAuteurs,
                    'lesDates'          => $lesDatesDePublication,
                    'lesNbCom'          => $lesNbCom,
                    'images'            => $images,
                    'pageType'          => 'supprimer_entity',
                    'routePaginator'    => $routeName
                   ));
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
    
      $lesDomaines              =   $serviceAvis->getDomaineWithLink($avis);
      $lesAuteurs               =   $serviceAvis->getAuteursAvis($avis);
      $lesDatesDePublication    =   $serviceAvis->getDatePublication($avis);
      $lesNbCom                 =   $serviceAvis->getNbCommentaireAvis($avis);
      $lesVotes                 =   $serviceAvis->getLesVotes($avis, $manager);
      $images                   =   $serviceAvis->getImages($avis);
      
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
   * @Secure(roles="ROLE_USER")
   * 
   * @return type
   */
  public function ajouterAction()
  {
     $serviceAcl = $this->container->get('mind_site.acl_security'); 
     $serviceBootstrapFlash = $this->container->get('bc_bootstrap.flash');
     $suivis = $this->container->get('mind_media.suivis');
     $domaineService = $this->container->get('mind_site.domaine');
     $em = $this->getDoctrine()->getManager();
     $domaineArray = $em->getRepository('MindSiteBundle:Domaine')->getAllDomainesInArray();
      
      //Création du formulaire à partir de l'entité et du type de formulaire
     $avis = new \Mind\SiteBundle\Entity\Avis;
     $form = $this->createForm(new AvisType($domaineArray), $avis);
     
     //On récupère la classe requete
     $request = $this->getRequest();
     
    if($request->getMethod() == 'POST')
    {
        
        $idAuteur = $this->get('security.context')->getToken()->getUser()->getId();
        $avis->setAvisAuteur($idAuteur);
        
        $form->bind($request);
        
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
            $actionImage->persisteImagesForAvis($images, $avis);
            $em->flush();
            
            //ACL
            $tabAcl     = array();
            $tabAcl[]   = $avis;
            $serviceAcl->updateAcl($tabAcl);
            
            //message de confirmation 
            $messageDeConfirmation = "L'avis a été publié avec succès.";
            $serviceBootstrapFlash->success($messageDeConfirmation);
            
            $parametres = array(
                'auteur'    => $this->container->get('security.context')->getToken()->getUser()->getSlug(),
                'slug'      => $avis->getSlug()
            );            
            
            return $this->redirect($this->generateUrl('mind_site_avis_voir', $parametres));
        }
       
    }
    
    $lesDomaines = $domaineService->getHtmlFormDomaineTree('avis'); 
    
    $template = sprintf('MindSiteBundle:Forms:form_add_avis.html.twig'); 
    return $this->container->get('templating')->renderResponse($template, array('lesDomaines'   => $lesDomaines,
                                                                                'form'  => $form->createView()
                                                                                ));
  }
  
   /**
    * 
    * @Secure(roles="ROLE_USER")
    * 
    * @param type $idAvis
    * @return type
    */
   public function modifierAction($idAvis)
   {
       
       $serviceAcl = $this->container->get('mind_site.acl_security');
       $serviceAvis = $this->container->get('mind_site.avis');
       $domaineService = $this->container->get('mind_site.domaine');
       $serviceBootstrapFlash = $this->container->get('bc_bootstrap.flash');
       
       $request = $this->getRequest();
       $em = $this->getDoctrine()->getManager();
       $domaineArray = $em->getRepository('MindSiteBundle:Domaine')->getAllDomainesInArray();
       $avis = $serviceAvis->getAvisToUpdate($idAvis);
       
       $serviceAcl->checkPermission('EDIT', $avis);
       
       if($request->getMethod() == "POST"){
           
           $avis->setAvisDateEdition(new \DateTime());
           $form = $this->createForm(new AvisModifierType($domaineArray), $avis);
           
           $form->bind($request);
           
           
           if($form->isValid()){
               
               $em->persist($avis);
               
               //Images
//                $actionImage = $this->container->get('mind_media.upload_file');
//                $images = $actionImage->createFileInfos();
//                $actionImage->persisteImagesForAvis($images, $avis);
            
               $em->flush();
               
               //message de confirmation 
               $messageDeConfirmation = "L'avis a été modifié avec succès.";
               $serviceBootstrapFlash->success($messageDeConfirmation);
               
               $parametre = array(
                   'auteur'     => $this->getUser()->getSlug(),
                   'slug'       => $avis->getSlug()
               );
               
               return $this->redirect($this->generateUrl('mind_site_avis_voir', $parametre));
           }
       }else{
            
            $form = $this->createForm(new AvisModifierType($domaineArray), $avis);
            
       }
       
       $lesDomaines = $domaineService->getHtmlFormDomaineTree('avis', $avis->getAvisDomaine()); 
       
       $template = sprintf('MindSiteBundle:Forms:form_modifier_avis.html.twig');
       return $this->container->get('templating')->renderResponse($template, 
               array(
                        'form'          => $form->createView(),
                        'idAvis'        => $idAvis,
                        'lesDomaines'   => $lesDomaines
               ));
   }
 
   /**
    * 
    * @Secure(roles="ROLE_USER")
    * @param type $idAvis
    * @return \Symfony\Component\HttpFoundation\Response
    */
  public function supprimerAction($idAvis)
  {   
      $request = $this->getRequest();
      $serviceAcl = $this->container->get('mind_site.acl_security');
      $serviceAvis = $this->container->get('mind_site.avis');
      $serviceSuivis = $this->container->get('mind_media.suivis');
      $serviceAbonnement = $this->container->get('mind_media.abonnement');
      $idUserCourant = $this->container->get('security.context')->getToken()->getUser()->getId();
      
      if($request->getMethod() == 'POST'){
          
          $idAvis = $_POST['idAvis'];
          $avis = $serviceAvis->getAvisToUpdate($idAvis);
          $serviceAcl->checkPermission('DELETE', $avis);
          
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

