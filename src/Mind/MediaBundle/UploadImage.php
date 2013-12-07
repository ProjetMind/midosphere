<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mind\MediaBundle;

use Gedmo\Uploadable\UploadableListener;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Mind\SiteBundle\Acl\AclSecurity;

/**
 * Description of CustomFileInfo
 *
 * @author root
 */
class UploadImage {
    
    protected $aclSecurity;
    protected $idEntity;
    protected $typeEntity;
    protected $uploadableListener;
    protected $doctrine;
    protected $manager;


    public function __construct(Registry $doctrine, UploadableListener $uploadable, AclSecurity $aclSecurity) {
        
        $this->doctrine             = $doctrine;
        $this->manager              = $doctrine->getManager();
        $this->uploadableListener   = $uploadable;
        $this->aclSecurity          = $aclSecurity;
        
    }
    
    public function createFileInfos(){
    
        $tabInfosImage = array();
        $images = $_FILES['filesImages'];
        
        
        $nbImage = count($images["name"]);
        $i = 0;
        
        while($i < $nbImage){
            
            if($images['name'][$i] != null){
                $imageInfos = array(
                                        'error'         =>  $images['error'][$i],
                                        'size'          =>  $images['size'][$i],
                                        'type'          =>  $images['type'][$i],
                                        'tmp_name'      =>  $images['tmp_name'][$i],
                                        'name'          =>  $images['name'][$i]
                        );

                $tabInfosImage[] = $imageInfos;
            }
            $i++;
        }
        
        return $tabInfosImage;
    }
    
    public function createFileInfosAvatar($images){
        
    
        $imageInfos = array(
                                    'error'         =>  $images->getError(),
                                    'size'          =>  $images->getSize(),
                                    'type'          =>  $images->getMimeType() ,
                                    'tmp_name'      =>  $images->getPathName(),
                                    'name'          =>  $images->getClientOriginalName()
                    );  
        
        return $imageInfos;
    }
    
    public function persisteImagesForAvis($images, $avis){
        
        $tabAcl = array();
        if(is_array($images)){

            foreach ($images as $uneImage){

                $imageAvis = new \Mind\MediaBundle\Entity\ImageAvis();
                $imageAvis->setAvis($avis->getId());
                $fileInfos = new \Gedmo\Uploadable\FileInfo\FileInfoArray($uneImage);
                $this->uploadableListener->addEntityFileInfo($imageAvis, $fileInfos);

                $this->manager->persist($imageAvis);
                $this->manager->flush();
                $tabAcl[] = $imageAvis;
            }
        }
        $this->aclSecurity->updateAcl($tabAcl);
    }


    public function getIdEntity(){
        
        return $this->idEntity;
    }
    
    public function getTypeEntity(){
        
        return $this->typeEntity;
    }
    
    public function setIdEntity($idEntity){
        
        $this->idEntity = $idEntity;
    }
    
    public function setTypeEntity($typeEntity){
        
        $this->typeEntity = $typeEntity;
    }
    
}

?>
