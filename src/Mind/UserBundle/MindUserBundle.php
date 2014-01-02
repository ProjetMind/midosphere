<?php

namespace Mind\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MindUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
    
    public function boot() {

        $doctrine = $this->container->get('doctrine');
	        $doctrine->getEntityManager()->getConfiguration()->addFilter(
	            'soft-deleteable',
	            'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
	            );

        $em = $doctrine->getEntityManager();
        $em->getFilters()->enable('soft-deleteable');
    }
}
