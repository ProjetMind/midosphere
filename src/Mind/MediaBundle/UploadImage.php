<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mind\MediaBundle;

/**
 * Description of CustomFileInfo
 *
 * @author root
 */
class UploadImage {
    
    protected $idEntity;
    protected $typeEntity;

    public function createFileInfos(){
    
        $tabInfosImage = array();
        $images = $_FILES['filesImages'];
        
        
        $nbImage = count($images["name"]);
        $i = 0;
        
        while($i < $nbImage and $images['name'][$i] != null){
            
            $imageInfos = array(
                                    'error'         =>  $images['error'][$i],
                                    'size'          =>  $images['size'][$i],
                                    'type'          =>  $images['type'][$i],
                                    'tmp_name'      =>  $images['tmp_name'][$i],
                                    'name'          =>  $images['name'][$i]
                    );
            
            $tabInfosImage[] = $imageInfos;
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
