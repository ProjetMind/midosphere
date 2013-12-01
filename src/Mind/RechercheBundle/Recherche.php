<?php

namespace Mind\RechercheBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Recherche {
    
    protected $doctrine;
    protected $manager;
    protected $dateFormatage;
    protected $security;
    protected $container;
    protected $minLengthTerms = 2;
    protected $msg  = array(
        'termsVide'     => 'Vous devez saisir au moins un terme de recherche.',
        'optionsVide'   => 'Vous devez saisir au moins une option de recherche.',       
        'termsCourt'     => 'La valeur du champ de recherche est trop courte. Elle doit faire au minimum %s caractères.'
    );


    public function __construct(Registry $doctrine, SecurityContextInterface $security, ContainerInterface $container) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->security         = $security;
        $this->container        = $container;
        
    }
    
    /**
     * 
     * Options de recherche des termes 
     * 
     * @return int
     */
    public function getOptionsFiltres(){
        
        $request        = $this->container->get('request');
        
        if($request->getMethod() === "POST"){
            
            $optionsFiltres = $request->get('optionsFiltres');
            if(empty($optionsFiltres)){
                $optionsFiltres = 1;
            }
        }else{
            $optionsFiltres = 1;
        }
        
        return $optionsFiltres;
    }
    
    /**
     * 
     * Retourne les options de recherche 
     * 
     * @return array
     */
    public function getOptionsRecherche(){
        
        $request                = $this->container->get('request');
        
        if($request->getMethod() === "POST"){
            
            $optionsDeRecherche = $request->get('optionsDeRecherche');
            
            if(!is_array($optionsDeRecherche)){
                $optionsDeRecherche = explode(',', $request->get('optionsDeRecherche'));
                
            }
            
        }else{
            $optionsDeRecherche = array();
        }
        
        return $optionsDeRecherche;
        
    }
    
    /**
     * 
     * Retourne les terms de la recherche
     * 
     * @return sring|null
     */
    public function getTermsRecherche(){
        
        $request                = $this->container->get('request');
        
        if($request->getMethod() === "POST"){
            
            $termsDeRecherche   = $request->get('inputHeaderSearch');
        }else{
            $termsDeRecherche = "";
        }
       
        return $termsDeRecherche;
    }
    
    /**
     * 
     * Vérifie la longeur du termes de recherche
     * 
     * @return boolean
     */
    public function getLenghtTerms(){
        
        $request                = $this->container->get('request');
        
        if($request->getMethod() === "POST"){
            
            $termsdeRecherche = $this->getTermsRecherche();
            if(strlen($termsdeRecherche) < $this->minLengthTerms){
                return false;
            }else{
                return true;
            }
        }
        
    }
    
    /**
     * 
     * Message d'erreur lié à la recherche
     * 
     * @return array
     */
    public function getMessage(){
        
        $msg                = array();
        $request            = $this->container->get('request');
        $termsDeRecherche   = $this->getTermsRecherche();
        $optionsDeRecherche = $this->getOptionsRecherche();
        $length             = $this->getLenghtTerms();

        if($request->getMethod() === "POST"){
            
            if(empty($termsDeRecherche)){
                $msg[] = $this->msg['termsVide'];
            }

            if(empty($optionsDeRecherche) or $optionsDeRecherche[0] == ""){
                $msg[] = $this->msg['optionsVide'];
            }

            if(!$length and !empty($termsDeRecherche)){
                $msg[] = sprintf($this->msg['termsCourt'], $this->minLengthTerms);
            }
        }
            
        return $msg;
    }
    
    public function getAvis(){
        
        $termsDeRecherche   = $_POST['inputHeaderSearch'];
        $optionsFiltres     = $_POST['optionsFiltres'];
            if(empty($optionsFiltres)){
                $optionsFiltres = 1;
            }
        $repo               = $this->manager->getRepository('MindSiteBundle:Avis');
        $avis               = $repo->findAvisByTermsRecherche($optionsFiltres, $termsDeRecherche);
        return $avis;
    }
    
    public function getQuestions(){
        
        $termsDeRecherche   = $_POST['inputHeaderSearch'];
        $optionsFiltres     = $_POST['optionsFiltres'];
            if(empty($optionsFiltres)){
                $optionsFiltres = 1;
            }
        $repo               = $this->manager->getRepository('MindSiteBundle:Question');
        $questions          = $repo->findQuestionsByTermsRecherche($optionsFiltres, $termsDeRecherche);
        
        return $questions;
    }
    
    public function getDomaines(){
        
        $termsDeRecherche   = $_POST['inputHeaderSearch'];
        $optionsFiltres     = $_POST['optionsFiltres'];
        if(empty($optionsFiltres)){
                $optionsFiltres = 1;
         }
            
       $repo                = $this->manager->getRepository('MindSiteBundle:Domaine');
       $domainesTree        = $repo->getDomainesByTermsRecherche($optionsFiltres, 
                                                                 $termsDeRecherche, 
                                                                 $this->container->get('router'));
            
       return $domainesTree;      
    }
    
    public function getUsers(){
        
        $termsDeRecherche   = $_POST['inputHeaderSearch'];
        $optionsFiltres     = $_POST['optionsFiltres'];
        if(empty($optionsFiltres)){
                $optionsFiltres = 1;
         }
         
        $repo                = $this->manager->getRepository('MindUserBundle:User');
        $users               = $repo->getUsersByTermsRecherche($optionsFiltres, 
                                                               $termsDeRecherche);
            
       return $users; 
    }
}
