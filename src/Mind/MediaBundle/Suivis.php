<?php

namespace Mind\MediaBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mind\SiteBundle\Acl\AclSecurity;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Suivis {

    protected $container;
    protected $aclSecurity;
    protected $doctrine;
    protected $manager;
    protected $idUser;
    protected $idEntity;
    protected $typeEntity;
    protected $repository;
    protected $security;
    protected $optionsSearch = array(
                                        'idUser'        => "",
                                        'idEntity'      => "",
                                        'typeEntity'    => ""
                                    );

    public function __construct(Registry $doctrine, SecurityContextInterface $security, AclSecurity $aclSecurity,
                                ContainerInterface $container) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->repository       = $this->manager->getRepository('MindMediaBundle:Suivis');
        $this->security         = $security;
        $this->aclSecurity      = $aclSecurity;
        $this->container        = $container;
    }

    public function getSuivisAvis($idUser){
        
        $optionsSearch = array(
                                    'idUser'        => $idUser,
                                    'typeEntity'    => 'avis',
                                    'disabled'      => true
                              );
        
        $avisSuivis = $this->repository->findBy($optionsSearch);
        $repositoryAvis = $this->manager->getRepository('MindSiteBundle:Avis');
        $tabAvis = array();
        
        foreach ($avisSuivis as $unAvisSuivis){
            $tabAvis[] = $repositoryAvis->find($unAvisSuivis->getIdEntity());
        }
        
       return $tabAvis;
    }
    
    public function getSuivisQuestions($idUser){
        
        $optionsSearch = array(
                                    'idUser'        => $idUser,
                                    'typeEntity'    => 'question',
                                    'disabled'      => true
                              );
        
        $questionsSuivis = $this->repository->findBy($optionsSearch);
        
        $repositoryQuestions = $this->manager->getRepository('MindSiteBundle:Question');
        $tabQuestions = array();
        
        foreach ($questionsSuivis as $uneQuestionSuivis){
            $tabQuestions[] = $repositoryQuestions->find($uneQuestionSuivis->getIdEntity());
        }
        
       return $tabQuestions;
    }

    public function createSuivisForUser(array $options){
        
        $this->init($options);
        $checkSuivis = $this->checkSuivis();
        $this->initSuivis($checkSuivis);
        
    }
    
    public function init(array $options){
        
        $this->idUser       = $options['idUser'];
        $this->idEntity     = $options['idEntity'];
        $this->typeEntity   = $options['typeEntity'];
        
        $this->optionsSearch['idUser']      = $this->idUser;
        $this->optionsSearch['idEntity']    = $this->idEntity;
        $this->optionsSearch['typeEntity']  = $this->typeEntity;
        
    }
    
    public function initSuivis($checkSuivis){
        
        if($checkSuivis == false){
            
            $suivis = new \Mind\MediaBundle\Entity\Suivis;
            
            $suivis->setIdUser($this->idUser);
            $suivis->setIdEntity($this->idEntity);
            $suivis->setTypeEntity($this->typeEntity);
            $suivis->setDisabled(true);
            $this->manager->persist($suivis);
            $this->manager->flush();
            $tabAcl = array();
            $tabAcl[] = $suivis;
            $this->aclSecurity->updateAcl($tabAcl);
            if($this->typeEntity == "avis"){
                $message = "Vous suivez maintenat cet avis.";
            }
            if($this->typeEntity == "question"){
                $message = "Vous suivez maintenat cette question.";
            }
            
            $this->container->get('bc_bootstrap.flash')->success($message);
            
        }else{ 
            $suivis = $this->repository->findOneBy($this->optionsSearch);
            $this->aclSecurity->deleteAcl($suivis);
            $this->manager->remove($suivis);
            $this->manager->flush();
            
            $message = "Vous ne suivez plus cet avis.";
            $this->container->get('bc_bootstrap.flash')->success($message);
            
        }
        
        //$this->bcBootsrapFlash->success($message);
       
    }


    public function checkSuivis(array $optionsSearch = null){
        
        if($optionsSearch == NULL){
            $suivis = $this->repository->findBy($this->optionsSearch);
        }else{
            $suivis = $this->repository->findBy($optionsSearch);
            
        }
        
        
        if(empty($suivis)){
            $checkSuivis = false;
        }else{
            $checkSuivis = true;
        }
        
        return $checkSuivis;
    }
    
    public function isValidUser($idUser){
        
        $user = $this->manager->getRepository('MindUserBundle:User')->find($idUser);
        
        if(!empty($user)){
            $userExiste = true;
        }else{
            $userExiste = false;
        }
        
        return $userExiste;
    }
    
    public function isValidEntity($idEntity, $typeEntity){
        
        $typeEntity = ucfirst($typeEntity);
        $entity = $this->manager->getRepository('MindSiteBundle:'.$typeEntity)->find($idEntity);
        
        if(!empty($entity)){
            $entityExiste = true;
        }else{
            $entityExiste = false;
        }
        
        return $entityExiste;
    }
    
    public function isValidTypeEntity($typeEntity){
        
        $isValidTypeEntity = true;
                
        switch ($typeEntity){
            
            case 'avis':
                break;
            
            case 'question':
                break;
            
            default :
                $isValidTypeEntity = false;
                break;
            
        }
        
        return $isValidTypeEntity;
    }
}

?>
