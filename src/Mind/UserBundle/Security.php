<?php

namespace Mind\UserBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class Security {
    
    protected $container;
    
    public function __construct(ContainerInterface $container) {
        
        $this->container    = $container;
    }
    
    public function accessDenied(){
        
        throw new AccessDeniedException("Vous n'avez pas accès à la resource demandée.'");
    }
    
    public function NotFound($object, $resources){
        
        if(empty($object)){
            $message = "%s n'existe pas.";
            throw new NotFoundHttpException(sprintf($message, $resources));
        }
        
    }
}
