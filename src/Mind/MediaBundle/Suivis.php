<?php

namespace Mind\MediaBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;

class Suivis {

    protected $doctrine;
    protected $manager;
    protected $idUser;
    protected $idEntity;
    protected $typeEntity;
    protected $repository;
    protected $optionsSearch = array(
                                        'idUser'        => "",
                                        'idEntity'      => "",
                                        'typeEntity'    => ""
                                    );

    public function __construct(Registry $doctrine) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->repository       = $this->manager->getRepository('MindMediaBundle:Suivis');
    }

    public function getSuivisAvis($idUser){
        
        $optionsSearch = array(
                                    'idUser'        => $idUser,
                                    'typeEntity'    => 'avis',
                                    'disabled'      => false
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
                                    'disabled'      => false
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
    
    protected function init(array $options){
        
        $this->idUser       = $options['idUser'];
        $this->idEntity     = $options['idEntity'];
        $this->typeEntity   = $options['typeEntity'];
        
        $this->optionsSearch['idUser']      = $this->idUser;
        $this->optionsSearch['idEntity']    = $this->idEntity;
        $this->optionsSearch['typeEntity']  = $this->typeEntity;
        
    }
    
    protected function initSuivis($checkSuivis){
        
        if($checkSuivis == false){
            
            $suivis = new \Mind\MediaBundle\Entity\Suivis;
            
            $suivis->setIdUser($this->idUser);
            $suivis->setIdEntity($this->idEntity);
            $suivis->setTypeEntity($this->typeEntity);
            $suivis->setDisabled(false);
            $this->manager->persist($suivis);
            
        }else{
            $suivis = $this->repository->findOneBy($this->optionsSearch);
            $this->manager->remove($suivis);
        }
        
        $this->manager->flush();
    }


    protected function checkSuivis(){
        
        $suivis = $this->repository->findBy($this->optionsSearch);
        
        if(empty($suivis)){
            $checkSuivis = false;
        }else{
            $checkSuivis = true;
        }
        
        return $checkSuivis;
    }
}

?>
