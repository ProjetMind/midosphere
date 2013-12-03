<?php

namespace Mind\MediaBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;


class Avatar extends \Twig_Extension {
    
    protected $doctrine;
    protected $manager;
    protected $security;
    
    public function __construct(Registry $doctrine, SecurityContextInterface $security) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->security         = $security;
    }
    
    public function getAvatar($idUser){
        
        $avatar = $this->manager
                       ->getRepository('MindMediaBundle:Avatar')
                       ->findOneBy(array('idUser'=>$idUser));
        
        return $avatar;
    }
    
    public function supprimerAvatar($idUser){
     
        $avatar = $this->manager
                       ->getRepository('MindMediaBundle:Avatar')
                       ->findOneBy(array('idUser'=>$idUser));
        if(!empty($avatar)){
            if($avatar->getPath() == "img/avatar-femme.jpeg" or $avatar->getPath() == "img/avatar-homme.jpeg" ){
                
            }else{
                $this->manager->remove($avatar);
            }
        }
    }
    
    public function updateUserPath($path){
        
        $user = $this->security->getToken()->getUser();
        $user->setPath($path);
        $this->manager->flush();       
    }

    public function getName()
    {
        return 'avatar_extension';
    }
    
}

?>
