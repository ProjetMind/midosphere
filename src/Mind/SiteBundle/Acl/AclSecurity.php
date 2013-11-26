<?php

namespace Mind\SiteBundle\Acl;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;

class AclSecurity {
    
    protected $container;
    protected $aclProvider;
    protected $securityContext;

    public function __construct(ContainerInterface $container) {
        
        $this->container        = $container;
        $this->aclProvider      = $this->container->get('security.acl.provider');
        $this->securityContext  = $this->container->get('security.context');
    }
    
    /**
     * 
     * Création de l'ACL d'un $objet
     * 
     * @param array $$objets Avis|Question| etc
     * 
     * @return array Array objet identity ACL
     */
    protected function createAcl(array $objets){
        
        $tabObjetsAcl       = array();
        
        foreach ($objets as $objet){
            
            $objetIdentity      = ObjectIdentity::fromDomainObject($objet);
            $tabObjetsAcl[]     = $this->aclProvider->createAcl($objetIdentity);   
        }
        
        return $tabObjetsAcl;
    }
    
    /**
     * 
     * donne accès au propriétaire
     */
    public function updateAcl(array $objets, $user = null){
        
        $tabObjetsAcl       = $this->createAcl($objets);
        $securityIdentity   = $this->getUserSecurityIdentity($user);
        
        foreach ($tabObjetsAcl as $objetAcl){
            
            $objetAcl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $this->aclProvider->updateAcl($objetAcl);
        };
        
    }
    
    /**
     * 
     * retrouve l'identifiant de sécurité de l'utilisateur actuellement connecté
     * 
     * @return type Description
     */
    protected function getUserSecurityIdentity($user){
        
        if($user === null){
            $user = $this->securityContext->getToken()->getUser();
        }
        
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        
        return $securityIdentity;
    }
    
    /**
     * 
     * Vérifie si un untilisateur a les permission pour faire une action
     * 
     * @param type $action
     * @param type $object
     * @throws AccessDeniedException
     */
    public function checkPermission($action, $object){
        
        // check for edit access
        if (false === $this->securityContext->isGranted(strtoupper($action), $object))
        {
            throw new AccessDeniedException();
        }
    }
    
}
