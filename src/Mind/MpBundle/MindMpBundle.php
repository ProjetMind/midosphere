<?php

namespace Mind\MpBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MindMpBundle extends Bundle
{
    public function boot() {

        $doctrine = $this->container->get('doctrine');
	        $doctrine->getManager()->getConfiguration()->addFilter(
	            'soft-deleteable',
	            'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
	            );

        $em = $doctrine->getManager();
        $em->getFilters()->enable('soft-deleteable');
    }
}
