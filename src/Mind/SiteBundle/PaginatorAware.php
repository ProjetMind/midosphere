<?php

namespace Mind\SiteBundle;

use Knp\Bundle\PaginatorBundle\Definition\PaginatorAware as BasePaginatorAware;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;

class PaginatorAware extends BasePaginatorAware {
    
    protected $doctrine;
    protected $manager;
    protected $paginate;
    
    public function __construct(Registry $doctrine) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->paginate         = $this->getPaginator();
    }
    
    
    
}

?>