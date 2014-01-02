<?php

namespace Mind\MediaBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;

class Abonnement {

    protected $doctrine;
    protected $manager;
    protected $security;
    
    public function __construct(Registry $doctrine, SecurityContextInterface $security) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->security         = $security;
    }
    
    public function deleteAbonnement($idUser, $typeAbonnement){
        
        $idUserCourant = $this->security->getToken()->getUser()->getId();
        
        if(!empty($idUserCourant) and $idUser == $idUserCourant){
            
            switch ($typeAbonnement){

                case 'user':
                    $abonnement = $this->manager
                                       ->getRepository('MindMediaBundle:Abonnement')
                                       ->findOneBy(array('idSouscripteur'=>$idUserCourant));
                    break;

                case 'domaine':
                    $abonnement = $this->manager
                                       ->getRepository('MindMediaBundle:AbonnementDomaine')
                                       ->findOneBy(array('idUser'=>$idUserCourant));
                    break;
            }
            
            $this->manager->remove($abonnement);
            
        }
    }
}

?>
