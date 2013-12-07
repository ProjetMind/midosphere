<?php

namespace Mind\MediaBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mind\SiteBundle\Acl\AclSecurity;

class Avatar extends \Twig_Extension {
    
    protected $doctrine;
    protected $manager;
    protected $security;
    protected $aclSecurity;


    public function __construct(Registry $doctrine, SecurityContextInterface $security, AclSecurity $aclSecurity) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->security         = $security;
        $this->aclSecurity      = $aclSecurity;
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
                $this->manager->remove($avatar);
                $this->manager->flush();
                $this->aclSecurity->deleteAcl($avatar);
        }
    }
    
    public function updateUserPath($path){
        
        $user = $this->security->getToken()->getUser();
        $this->aclSecurity->checkPermission('EDIT', $user);
        $user->setPath($path);
        $this->manager->flush();       
    }

    public function getName()
    {
        return 'avatar_extension';
    }
    
}

?>
