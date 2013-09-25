<?php

namespace Mind\MediaBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;


class Images {
   
    protected $doctrine;
    protected $manager;
    protected $idEntity;
    protected $typeEntity;
    
    public function __construct(Registry $doctrine) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
    }
    
    public function getImages($lesAvis){
        
        switch ($this->typeEntity){
            
            case 'avis':
                $imagesOfEntity = $this->getImagesForAvis($lesAvis);
                break;
        }
        
        return $imagesOfEntity;
    }
    
    protected function getImagesForAvis($lesAvis){
        
        $tabImages = array();
        
        foreach ($lesAvis as $unAvis){
            
            $idAvis = $unAvis->getId();
            $options = array(
                            'avis'  => $idAvis
                        );
            
            $imagesAvis = $this->manager
                               ->getRepository('MindMediaBundle:ImageAvis')
                               ->findBy($options);
            
            $tabImages[$idAvis] = $imagesAvis;
        }
        
        return $tabImages;
    }
    
    public function setTypeEntity($typeEntity){
        
        $this->typeEntity = $typeEntity;
    }
}

?>
