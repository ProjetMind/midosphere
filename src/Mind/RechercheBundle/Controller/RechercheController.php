<?php

namespace Mind\RechercheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RechercheController extends Controller
{
    /**
     * 
     * Index de la page de recherche
     * 
     * @return Response
     */
    public function indexAction()
    {
        $serviceRecherche       = $this->container->get('mind_recherche.recherche');
        $optionsDeRecherche     = $serviceRecherche->getOptionsRecherche();
        $termsDeRecherche       = $serviceRecherche->getTermsRecherche();
        $optionsFiltres         = $serviceRecherche->getOptionsFiltres();
        $msg                    = $serviceRecherche->getMessage();
        $serviceBcBootstrapFlash = $this->container->get('bc_bootstrap.flash');
        
        foreach ($msg as $unMsg){
            $serviceBcBootstrapFlash->info($unMsg);
        }
        
        $template = "MindRechercheBundle:Recherche:recherche.html.twig";
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'optionsDeRecherche'        => $optionsDeRecherche,
                        'termsDeRecherche'          => $termsDeRecherche,
                        'optionsFiltres'            => $optionsFiltres,
                        'msg'                       => $msg
                     ));
    }
    
    public function getResultatsForAvisAction(){
        
        //Service
        $serviceRecherche       = $this->container->get('mind_recherche.recherche');
        $serviceAvis            = $this->container->get('mind_site.avis');
        $paginator              = $this->get('knp_paginator');
        
        //Variables
        $termsDeRecherche       = $serviceRecherche->getTermsRecherche();
        $limitParPage           = 20000000000;
        $page                   = 1;
        
        //Les éléments d'avis'
        $titreGroup             = "";
        $lesAvis                = $paginator->paginate(
                                                $serviceRecherche->getAvis(),
                                                $page/*page number*/,
                                                $limitParPage/*limit per page*/
                            );
                            
        $lesDomaines            = $serviceAvis->getDomaineWithLink($lesAvis);
        $lesAuteurs             = $serviceAvis->getAuteursAvis($lesAvis);
        $lesDatesDePublication  = $serviceAvis->getDatePublication($lesAvis);
        $lesNbCom               = $serviceAvis->getNbCommentaireAvis($lesAvis);
        $images                 = $serviceAvis->getImages($lesAvis);
        
        $template = 'MindSiteBundle::un_avis.html.twig';
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
                        'routePaginator'    => "",
                        'nbResult'          => count($serviceRecherche->getAvis())
                ));
    }
    
    public function getResultatsForQuestionsAction(){
        
        //Service
        $serviceRecherche       = $this->container->get('mind_recherche.recherche');
        $serviceQuestions       = $this->container->get('mind_site.questions');
        $paginator              = $this->get('knp_paginator');
        
        //Variables
        $limitParPage           = 20000000000;
        $page                   = 1;
        
        //Les éléments d'avis'
        $titreGroup             = "";
        $lesQuestions           = $paginator->paginate(
                                                $serviceRecherche->getQuestions(),
                                                $page/*page number*/,
                                                $limitParPage/*limit per page*/
                            );
                            
        $lesDomaines            = $serviceQuestions->getDomaineWithLink($lesQuestions);
        $lesAuteurs             = $serviceQuestions->getAuteursQuestion($lesQuestions);
        $lesDatesDePublication  = $serviceQuestions->getDatePublication($lesQuestions);
        $lesNbCom               = $serviceQuestions->getNbCommentaireQuestion($lesQuestions);
        
        $template = 'MindSiteBundle::une_question.html.twig';
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'lesQuestions'      => $lesQuestions,
                        'titreGroup'        => $titreGroup,
                        'lesDomaines'       => $lesDomaines,
                        'lesAuteurs'        => $lesAuteurs,
                        'lesDates'          => $lesDatesDePublication,
                        'lesNbCom'          => $lesNbCom,
                        'pageType'          => 'supprimer_entity',
                        'routePaginator'    => "",
                        'nbResult'          => count($serviceRecherche->getQuestions())
                ));
    }
    
    public function getResultatsForDomainesAction(){
     
        $serviceRecherche       = $this->container->get('mind_recherche.recherche');
        $domaines = $serviceRecherche->getDomaines();
        
        $template = 'MindRechercheBundle:Resultats:domaines_liste.html.twig';
        
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'lesDomaines'       => $domaines,
                        'nbResult'          => count($domaines)
                ));
    }
    
    public function getResultatsForMembresAction(){
    
        $serviceRecherche       = $this->container->get('mind_recherche.recherche');
        $users = $serviceRecherche->getUsers();
        $template = 'MindUserBundle::liste_user.html.twig';
        
        return $this->container->get('templating')->renderResponse($template,
                array(
                        'users'         => $users,
                        'nbResult'      => count($users)
                ));
        
    }
}
